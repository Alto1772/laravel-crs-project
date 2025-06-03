<?php

namespace App\Services;

use App\Models\BoardProgram;
use App\Models\Questionnaire;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class QuestionnaireService
{
    public function populate(Questionnaire $questionnaire, array $data)
    {
        foreach ($data['items'] as $item) {
            $question = $questionnaire->questions()->create([
                'title' => $item['title'],
                'order_index' => $item['index'],
            ]);

            $question->choices()->createMany(Arr::map($item['choices'], fn ($choice, $index) => [
                'order_index' => $index,
                'text' => Str::trim($choice['value']),
                'is_correct' => $choice['isCorrect'],
            ]));
        }
    }

    public function createNew(BoardProgram $program, string $title = '')
    {
        // return $program->questionnaires()->create([
        //     'title' => $title
        // ]);
        return $program->questionnaires()->create();
    }

    public function populateNew(BoardProgram $program, array $data, string $title = '')
    {
        return DB::transaction(function () use ($program, $data, $title) {
            $questionnaire = $this->createNew($program, $title);
            $this->populate($questionnaire, $data);

            return $questionnaire;
        });
    }

    public function importFromDatabaseFolder(): bool
    {
        $questionnairesPath = database_path('questionnaires');
        $programs = BoardProgram::with('college')->get();
        $failedCount = 0;

        foreach ($programs as $program) {
            $jsonPath = "{$questionnairesPath}/{$program->college->name}/{$program->name}.json";
            if (! file_exists($jsonPath)) {
                Log::warning("Error importing $jsonPath as it is not found. Skipping for \"{$program->fullName()}\".");
                $failedCount++;

                continue;
            }

            $data = json_decode(file_get_contents($jsonPath), true);
            $this->populateNew($program, $data);
        }

        if ($failedCount > 0) {
            Log::warning("A total of $failedCount out of {$programs->count()} failed data imports.");
        }

        return $failedCount == 0;
    }
}
