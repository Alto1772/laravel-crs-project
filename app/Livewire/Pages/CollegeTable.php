<?php

namespace App\Livewire\Pages;

use App\Livewire\DataTable;
use App\Models\College;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;

#[Title('College List')]
class CollegeTable extends DataTable
{
    protected function getDefaultSortField(): string
    {
        return 'name';
    }

    protected function getModelQuery()
    {
        return College::search($this->search)
            ->withCount(['board_programs as num_programs']);
    }

    protected function getTableView(): View
    {
        return view('livewire.pages.college-table');
    }

    protected function getTableDataKey(): string
    {
        return 'colleges';
    }

    protected function getTableModel(): string
    {
        return College::class;
    }
}
