<?php

namespace App\Livewire\Pages;

use App\Models\BoardProgram;
use App\Models\College;
use App\Models\Questionnaire;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('All Questionnaires')]
class QuestionnaireList extends Component
{
    public function render()
    {
        $boardPrograms = BoardProgram::with(['college', 'questionnaires'])
            ->withCount('questions')
            ->orderBy(College::select('name')->whereColumn('colleges.id', 'board_programs.college_id'))
            ->get();

        return view('livewire.pages.questionnaire-list', [
            'boardPrograms' => $boardPrograms,
        ]);
    }

    public function deleteQuestionnaires(BoardProgram $boardProgram)
    {
        $boardProgram->questionnaires()->delete();

        session()->flash('success', "All Questionnaires for {$boardProgram->name} successfully deleted.");
        $this->js('window.scrollTo(0,0)');
    }

    public function deleteQuestionnaire(Questionnaire $questionnaire)
    {
        $questionnaire->delete();

        session()->flash('success', "Questionnaire ID {$questionnaire->id} successfully deleted.");
        $this->js('window.scrollTo(0,0)');
    }
}
