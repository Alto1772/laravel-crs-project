<?php

namespace App\Livewire;

use App\Models\BoardProgram;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class ProgramsPieChart extends Component
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
    public function answers_count()
    {
        return BoardProgram::withCount([
            'questionnaires as answers_count' => function ($query) {
                $query->join('questions', 'questionnaires.id', '=', 'questions.questionnaire_id')
                    ->join('choices', 'questions.id', '=', 'choices.question_id')
                    ->join('answers', 'choices.id', '=', 'answers.choice_id');
            }
        ])
        ->orderBy('name')
        ->get()
        ->pluck('answers_count', 'name');
    }

    public function render()
    {
        return view('livewire.programs-pie-chart');
    }
}
