<?php

namespace App\Livewire\Pages;

use App\Services\UserQuestionnaireService;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Session;
use Livewire\Component;

class InputName extends Component
{
    #[Rule('required|string', message: 'A full name is required to enter the assessment.')]
    #[Session(key: 'survey.fullname')]
    public $fullName;

    public function submit(UserQuestionnaireService $service)
    {
        $this->validate();

        $service->resetAssessmentSession();
        session()->put('survey.randseed', $service->genRandSeed($this->fullName));

        $this->redirectRoute('questionnaire.take');
    }

    // Clear all one-time messages after any event triggered
    public function hydrate()
    {
        $this->resetValidation();
        session()->forget('warning');
    }

    public function render()
    {
        return view('livewire.pages.input-name')
            ->extends('layouts.app', [
                'layoutType' => 'custom',
                'hasNavbar' => false,
                'hasSidebar' => false,
            ]);
    }
}
