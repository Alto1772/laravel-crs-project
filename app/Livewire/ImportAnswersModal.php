<?php

namespace App\Livewire;

use App\Services\AnswerService;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImportAnswersModal extends Component
{
    use WithFileUploads;

    /** @var \App\Models\Questionnaire */
    public $questionnaire;

    #[Rule('nullable|boolean')]
    public bool $deleteAllAnswers = false;

    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile */
    #[Rule('required|file|mimes:csv,xsl,xslx')]
    public $inputCsv;

    public function updatedInputCsv(AnswerService $questionService)
    {
        $this->validate();

        if ($this->deleteAllAnswers) {
            $messageFmt = 'Successfully deleted all and imported %s entries.';
            $questionService->deleteAllAnswers($this->questionnaire);
        } else {
            $messageFmt = 'Successfully imported %s entries.';
        }

        [$count, $importedCount] = $questionService->importAnswersFromUpload($this->questionnaire, $this->inputCsv);

        if ($importedCount !== 0) {
            $partialCountMsg = $count == $importedCount ?
                "$importedCount" :
                "$importedCount out of $count";
            session()->flash('success', sprintf($messageFmt, $partialCountMsg));
        } else {
            session()->flash('error', "Error importing $count entries");
        }
        $this->dispatch('refresh');
    }

    public function render()
    {
        return view('livewire.import-answers-modal');
    }
}
