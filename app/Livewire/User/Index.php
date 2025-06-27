<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
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
    public $confirmChangeRoles = false;
    public $selectedRole;
    public $roleId;

    public function render()
    {
        $users = User::paginate(10);

        return view('livewire.user.index', [
            'users' => $users,
            'roles' => Role::all(),
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

    public function changeRoles($roleId)
    {
        $this->selectedRole = $roleId;
        $this->confirmChangeRoles = true;
    }

    public function changePermission()
    {
        Auth::user()->roles()->sync([$this->selectedRole]);

        $this->confirmChangeRoles = false;

        return redirect()->back()->with('success', 'Role changed successfully!');
    }
}
