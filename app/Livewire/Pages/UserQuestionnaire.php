<?php

namespace App\Livewire\Pages;

use App\Models\Questionnaire;
use App\Rules\CheckUserAnswer;
use App\Services\UserQuestionnaireService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Validator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Session;
use Livewire\Component;

class UserQuestionnaire extends Component
{
    // public Questionnaire $questionnaire;

    /** @var Collection<int, \App\Models\Question> */
    public Collection $questions;

    #[Session(key: 'survey.user-answers')]
    public array $userAnswers;

    #[Locked]
    public $hasMorePages;

    #[Locked]
    public $previousPageUrl;

    #[Locked]
    public $nextPageUrl;

    #[Locked]
    #[Session('survey.can-skip-to-results')]
    public $canSkipToResults;

    public function boot()
    {
        $this->withValidator(function (Validator $validator) {
            $validator->after(function (Validator $validator) {
                if ($validator->failed()) {
                    $this->dispatch('validation-error');
                }
            });
        });
    }

    public function mount(UserQuestionnaireService $service, int $next = 0)
    {
        // $questionnaires = $service->getRandomQuestionnaire($next);
        // abort_if($questionnaires === null, 404);

        // [$this->questionnaire, $this->hasMorePages] = $questionnaires;
        // abort_if($this->questionnaire === null, 404);

        $questions = $service->getQuestionsInRandom($next);
        abort_if($questions === null, 404);

        [$this->questions, $this->hasMorePages] = $questions;
        abort_if($this->questions === null, 404);

        $this->questions = $this->questions->load('choices');

        $this->previousPageUrl = $next - 1 < 0 ? route('questionnaire.input-name') : route('questionnaire.take', $next - 1);
        $this->nextPageUrl = $this->hasMorePages ? route('questionnaire.take', $next + 1) : url('/');
    }

    public function hydrateQuestions()
    {
        $this->questions->load('choices');
    }

    public function rules()
    {
        return [
            'userAnswers' => 'required_array_keys:' . $this->questions->pluck('id')->join(','),
            'userAnswers.*' => ['required', 'numeric', new CheckUserAnswer],
        ];
    }

    public function submit()
    {
        $this->validate();

        if ($this->hasMorePages) {
            $this->redirect($this->nextPageUrl);
        } else {
            $this->canSkipToResults = true;
            $this->redirectRoute('assessment-results');
        }
    }

    // #[Computed()]
    // public function questions()
    // {
    //     return $this->questionnaire->load('questions.choices')->questions;
    // }

    // #[Computed()]
    // public function board_program()
    // {
    //     return $this->questionnaire->load('board_program.college')->board_program;
    // }

    protected function checkQuestionIsRequired(int $id): bool
    {
        $errors = $this->getErrorBag();

        if ($errors->has('userAnswers.' . $id)) {
            return true;
        }

        if ($errors->has('userAnswers')) {
            return ! isset($this->userAnswers[$id]);
        }

        return false;
    }

    public function render()
    {
        return view('livewire.pages.user-questionnaire')
            ->extends('layouts.app', [
                'layoutType' => 'custom',
                'hasNavbar' => false,
                'hasSidebar' => false,
            ]);
    }
}
