<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

abstract class DataTable extends Component
{
    use WithPagination;

    public $search = '';

    public $perPage = 10;

    public $sortField;

    public $sortDirection = 'desc';

    protected $queryString = ['search', 'sortField', 'sortDirection'];

    public function __construct()
    {
        $this->sortField = $this->getDefaultSortField();
    }

    abstract protected function getDefaultSortField(): string;

    abstract protected function getModelQuery();

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function deleteRecord($id): void
    {
        $this->getTableModel()::destroy($id);

        session()->flash('success', 'Record deleted successfully!');
    }

    public function render(): View
    {
        $data = $this->getModelQuery()
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return $this->getTableView()->with($this->getTableDataKey(), $data);
    }

    abstract protected function getTableModel(): string;

    abstract protected function getTableView(): View;

    abstract protected function getTableDataKey(): string;
}
