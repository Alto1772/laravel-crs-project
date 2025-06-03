<?php

namespace App\Livewire;

use App\Models\College;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class UserCollegesList extends Component
{
    public Collection $colleges;

    public ?College $selected = null;

    public function mount()
    {
        $this->colleges = College::all();
    }

    public function hydrateSelected()
    {
        $this->selected?->load('board_programs');
    }

    public function placeholder()
    {
        return <<<'HTML'
            <div class="relative mt-4 flex min-h-32 min-w-full max-w-md flex-wrap content-center justify-center gap-4 sm:gap-8">
                <x-loading-overlay class="z-20 rounded-md" />
            </div>
        HTML;
    }

    public function render()
    {
        return view('livewire.user-colleges-list');
    }

    public function select(College $college)
    {
        $this->selected = $college;
    }
}
