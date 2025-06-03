<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class CheckUserAnswer implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $questionId = Str::afterLast($attribute, '.');
        $orderIndex = $value;

        $question = resolve(\App\Services\UserQuestionnaireService::class)->checkQuestionValidChoice($questionId, $orderIndex);

        if ($question === null) {
            $fail("Question ID $questionId not found.");
        } elseif ($question->answer_index === null) {
            $fail("Choice $orderIndex is not one of choices in question ID $questionId.");
        }
    }
}
