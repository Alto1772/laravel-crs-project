<?php

namespace App\Livewire;

use App\Models\BoardProgram;
use App\Services\QuestionnaireService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateQuestionnaireModal extends Component
{
    use WithFileUploads;

    public Collection $boardPrograms;

    #[Rule('required|exists:board_programs,id')]
    public int $programId;

    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile */
    #[Rule('required|file|mimes:json', message: 'Upload must be an extracted Google Forms JSON file')]
    public $inputJson;

    public function render()
    {
        return view('livewire.create-questionnaire-modal');
    }

    public function hydrateBoardPrograms()
    {
        $this->boardPrograms->load('college');
    }

    public function updatedInputJson(QuestionnaireService $questionnaireService)
    {
        $this->validate();

        $program = BoardProgram::find($this->programId);

        $data = json_decode($this->inputJson->get(), true);
        $questionnaire = $questionnaireService->populateNew($program, $data);

        // $this->dispatch('close-import-modal');
        $this->redirectRoute('admin.questionnaires.show', ['questionnaire' => $questionnaire]);
    }
}
