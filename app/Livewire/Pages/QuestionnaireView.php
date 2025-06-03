<?php

namespace App\Livewire\Pages;

use App\Models\Questionnaire;
use Livewire\Attributes\On;
use Livewire\Component;

#[On('refresh')]
class QuestionnaireView extends Component
{
    public Questionnaire $questionnaire;

    public function mount(Questionnaire $questionnaire)
    {
        $this->questionnaire = $questionnaire->load('questions.choices')->loadCount(['answer_rows', 'answers']);
    }

    public function hydrateQuestionnaire()
    {
        $this->questionnaire->load('questions.choices')->loadCount(['answer_rows', 'answers']);
    }

    public function render()
    {
        return view('livewire.pages.questionnaire-view');
    }
}
