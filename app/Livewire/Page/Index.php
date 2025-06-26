<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Page;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedPages = [];
    public $selectAll = false;
    public $confirmingDelete = false;

    protected $listeners = ['refreshCategories' => '$refresh'];

    public function render()
    {
        $pages = Page::paginate(10);

        return view('livewire.page.index', [
            'pages' => $pages,
        ]);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedPages = Page::pluck('id')->toArray();
        } else {
            $this->selectedPages = [];
        }
    }

    public function confirmDelete($id = null)
    {
        if ($id) {
            $this->selectedPages = [$id];
        }
        $this->confirmingDelete = true;
    }

    public function deleteCategory()
    {
        $categories = Page::whereIn('id', $this->selectedPages)->first();

        $categories->delete();

        $this->selectedPages = [];
        $this->selectAll = false;
        $this->confirmingDelete = false;

        session()->flash('message', 'Categories deleted successfully.');
        $this->dispatch('refreshCategories');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
