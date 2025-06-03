<?php

namespace App\Livewire\Pages;

use App\Models\BoardProgram;
use App\Services\KnnService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy]
#[Title('KNN Model Analysis')]
class KNNDashboard extends Component
{
    public bool $reportPage = false;

    public function placeholder()
    {
        return view('livewire.pages.knn-dashboard.placeholder');
    }

    public function retrain(KnnService $knnService)
    {
        $knnService->train();
        $this->reanalyze();
    }

    public function reanalyze()
    {
        unset($this->analysis);
    }

    #[Computed(persist: true, seconds: 20 * 60, key: 'knn-report')]
    public function analysis() {
        $analysis = app(KnnService::class)->analysisReport();

        foreach (['class_distribution', 'feature_importance', 'cluster_visualization', 'confusion_matrix'] as $key) {
            if (!empty($analysis[$key])) {
                $svgFile = 'reports/' . Str::random(12) . '.svg';
                throw_unless(Storage::put($svgFile, $analysis[$key]));
                $analysis[$key] = Storage::temporaryUrl($svgFile, now()->addSeconds(20 * 60));
            }
        }

        return $analysis;
    }

    #[Computed]
    public function classification_report()
    {
        return collect($this->analysis['classification_report'])->mapInto(Collection::class);
    }

    #[Computed]
    public function confusion_matrix() {
        return $this->analysis['confusion_matrix'];
    }

    #[Computed]
    public function board_programs() {
        return BoardProgram::all();
    }

    protected function format_percent(float $number){
        return number_format($number * 100, 2) . '%';
    }

    public function render()
    {
        return view('livewire.pages.knn-dashboard');
    }
}
