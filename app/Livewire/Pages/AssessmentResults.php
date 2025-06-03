<?php

namespace App\Livewire\Pages;

use App\Services\KnnService;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Session;
use Livewire\Component;

#[Lazy]
class AssessmentResults extends Component
{
    #[Locked]
    public $recommendations;

    #[Locked]
    public $recChart;

    #[Locked]
    #[Session(key: 'survey.fullname')]
    public $fullName;

    public $expand = false;

    // Lazy loading breaks service classes that have properties when using in mount()
    private KnnService $knnService;

    public function boot(KnnService $knnService)
    {
        $this->knnService = $knnService;
    }

    public function mount()
    {
        $recommendations = $this->knnService->predict(session('survey.user-answers'));
        $recommendations = collect($recommendations)->pluck('percentage', 'name')->filter(fn ($value) => $value > 0);

        $this->recommendations = $recommendations->sortBy('percentage');
        $this->recChart = $recommendations;
    }

    public function placeholder()
    {
        return view('livewire.pages.assessment-results.placeholder')
            ->extends('layouts.app', [
                'layoutType' => 'custom',
                'hasNavbar' => false,
                'hasSidebar' => false,
            ]);
    }

    public function render()
    {
        return view('livewire.pages.assessment-results')
            ->extends('layouts.app', [
                'layoutType' => 'custom',
                'hasNavbar' => false,
                'hasSidebar' => false,
            ]);
    }
}
