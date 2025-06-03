<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Questionnaire;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class UserQuestionnaireService
{
    // Variable seed to be set in AppServiceProvider
    public function __construct(public int $seed) {}

    public function genRandSeed(string $salt): int
    {
        $datetime = now()->toDateTimeLocalString();

        return crc32($datetime . $salt);
    }

    public function queryQuestionnaireRandom()
    {
        return Questionnaire::inRandomOrder($this->seed);
    }

    public function queryQuestionRandom()
    {
        return Question::query()
            ->from('questions', 't')
            ->joinSub(Question::query()
                ->select('questionnaire_id')
                ->selectRaw('RAND(?) AS random_value', [$this->seed])
                ->groupBy('questionnaire_id'),
                'r', fn (JoinClause $join) => $join->on('t.questionnaire_id', '=', 'r.questionnaire_id'))
            ->orderBy('r.random_value')
            ->orderBy('t.order_index')
            ->select('t.*');
    }

    public function getRandomQuestionnaire(int $offset = 0)
    {
        $result = $this->queryQuestionnaireRandom()->skip($offset)->take(2)->get();

        if ($result->isEmpty()) {
            return null;
        }

        return [$result->first(), $result->has(1)];
    }

    public function getQuestionnairesInRandom()
    {
        return $this->queryQuestionnaireRandom()->with('questions')->get();
    }

    public function checkQuestionValidChoice(int $questionId, int $orderIndex): Question
    {
        return Question::select(
            '*',
            'choices.text as answer_text',
            'choices.order_index as answer_index',
            'choices.is_correct as answer_correct',
        )->leftJoin('choices', function (JoinClause $join) use ($orderIndex) {
            return $join->on('questions.id', '=', 'choices.question_id')->where('choices.order_index', '=', $orderIndex);
        })->find($questionId);
    }

    public function getQuestionsInRandom(int $offset = 0, int $size = 25)
    {
        // $result = Question::orderBy('questionnaire_id', 'asc')
        //     ->inRandomOrder($this->seed)
        //     ->offset($offset * $size)
        //     ->limit($size + 1)
        //     ->get();
        $result = $this->queryQuestionRandom()
            ->offset($offset * $size)
            ->limit($size + 1)
            ->get();

        if ($result->isEmpty()) {
            return null;
        }

        return [$result->slice(0, $size), $result->has($size)];
    }

    public function doCheckUnanswered(array $answers, int $size = 25): Collection
    {
        $questionIds = array_keys($answers);
        // $allQuestionnaires = $this->queryQuestionnaireRandom()
        //     ->withCount(['questions' => fn (Builder $query) => $query->whereNotIn('id', $questionIds)])
        //     ->get()->map(function ($value, $key) {
        //         return $value->only(['id', 'questions_count']) + ['index' => $key];
        //     });

        // $unanswered = $allQuestionnaires->where('questions_count', '!=', 0);

        $unanswered = $this->queryQuestionRandom()
            // TODO: should we expose $size to this class?
            ->get()->map(function ($value, $key) use ($size) {
                return $value->only(['id']) + ['index' => intdiv($key, $size)];
            })
            ->whereNotIn('id', $questionIds);

        return $unanswered;
    }

    public function resetAssessmentSession()
    {
        Session::forget(['survey.randseed', 'survey.user-answers', 'survey.can-skip-to-results']);
    }
}
