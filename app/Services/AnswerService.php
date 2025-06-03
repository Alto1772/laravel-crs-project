<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\AnswerRow;
use App\Models\Choice;
use App\Models\Question;
use App\Models\Questionnaire;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;

class AnswerService
{
    public function importAnswersFromUpload(Questionnaire $questionnaire, UploadedFile $file)
    {
        return $this->importAnswersFromFile($questionnaire, $file->getPathname());
    }

    public function importAnswersFromFile(Questionnaire $questionnaire, string $path)
    {
        $data = (new FastExcel)->import($path, fn ($row) => collect($row));  // FastExcel doesn't convert rows as collections immediately so manually do it here
        $dataQuestions = $data->first()->keys()->skip(2)->nth(3);

        // Skip 2 columns within 3 steps
        $dataAnswers = $data->map(fn (Collection $item) => $item->values()->skip(2)->nth(3));
        $dataAnswersCount = $dataAnswers->map->count()->sum();

        $queriedQuestions = $dataQuestions->map(function ($dataQuestion) use ($questionnaire) {
            $dbQuestion = Question::whereBelongsTo($questionnaire)->where('title', '=', $dataQuestion)->first();

            if ($dbQuestion === null) {
                Log::error('IMPORT ANSWERS: Question title not found in db: {dataQuestion}', [
                    'questionnaireId' => $questionnaire->id,
                    'dataQuestion' => $dataQuestion,
                ]);

                return null;
            }

            return $dbQuestion;
        });

        $createdAnswers = collect();

        if ($queriedQuestions->whereNotNull()->isEmpty()) {
            return [$dataAnswersCount, 0];
        }

        DB::transaction(function () use ($dataAnswers, $questionnaire, $queriedQuestions, $createdAnswers) {
            foreach ($dataAnswers as $answerRow) {
                $dbRow = new AnswerRow;
                $dbRow->questionnaire()->associate($questionnaire);
                $dbRow->save();

                foreach ($answerRow->zip($queriedQuestions) as [$answer, $dbQuestion]) {
                    if ($dbQuestion === null) {
                        continue;
                    }

                    $dbChoice = Choice::whereBelongsTo($dbQuestion)->where('text', '=', $answer)->first();

                    if ($dbChoice === null) {
                        Log::error('IMPORT ANSWERS: Answer choice not found in db: {answer}', [
                            'answer' => $answer,
                            'questionId' => $dbQuestion->id,
                            'questionText' => $dbQuestion->title,
                        ]);

                        continue;
                    }

                    $dbAnswer = new Answer;
                    $dbAnswer->choice()->associate($dbChoice);
                    // $dbAnswer->question()->associate($dbQuestion);
                    $dbAnswer->answer_row()->associate($dbRow);
                    $dbAnswer->save();
                    $createdAnswers->push($dbAnswer);
                }
            }
        });

        return [$dataAnswersCount, $createdAnswers->count()];
    }

    public function importAnswersFromDatabaseFolder()
    {
        Questionnaire::with('board_program.college')->get()->each(function ($questionnaire) {
            $csvPath = database_path('raw-datasets/'
                . $questionnaire->board_program->college->name . '/'
                . $questionnaire->board_program->name . '.csv');
            Log::info("Importing answers from $csvPath");
            $this->importAnswersFromFile($questionnaire, $csvPath);
        });
    }

    public function deleteAllAnswers(Questionnaire $questionnaire)
    {
        $questionnaire->answers()->delete();
        $questionnaire->answer_rows()->delete();
    }
}
