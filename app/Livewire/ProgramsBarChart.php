<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BoardProgram;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;

#[Lazy]
class ProgramsBarChart extends Component
{
    public function placeholder()
    {
        return <<<'HTML'
            <div class="relative mt-4 flex h-full min-w-full max-w-md flex-wrap content-center justify-center gap-4 sm:gap-8">
                <x-loading-overlay class="z-20 rounded-md" />
            </div>
        HTML;
    }

    #[Computed]
    public function correct_answers_count()
    {
        return BoardProgram::withCount([
            'questionnaires as correct_answers_count' => function ($query) {
                $query->join('questions', 'questionnaires.id', '=', 'questions.questionnaire_id')
                    ->join('choices', 'questions.id', '=', 'choices.question_id')
                    ->join('answers', 'choices.id', '=', 'answers.choice_id')
                    ->where('choices.is_correct', '=', 'true');
            }
        ])
        ->orderBy('name')
        ->get()
        ->pluck('correct_answers_count', 'name');
    }

    public function render()
    {
        return view('livewire.programs-bar-chart');
    }
}
