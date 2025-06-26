<?php

namespace App\Livewire\Category;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedCategories = [];
    public $selectAll = false;
    public $confirmingDelete = false;

    protected $listeners = ['refreshCategories' => '$refresh'];

    public function render()
    {
        $categories = Category::paginate(10);

        return view('livewire.category.index', [
            'categories' => $categories,
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
            $this->selectedCategories = Category::pluck('id')->toArray();
        } else {
            $this->selectedCategories = [];
        }
    }

    public function confirmDelete($id = null)
    {
        if ($id) {
            $this->selectedCategories = [$id];
        }
        $this->confirmingDelete = true;
    }

    public function deleteCategory()
    {
        $categories = Category::whereIn('id', $this->selectedCategories)->first();

        $categories->delete();

        $this->selectedCategories = [];
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
