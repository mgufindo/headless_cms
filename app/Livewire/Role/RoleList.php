<?php

namespace App\Livewire\Role;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Role;

class RoleList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $confirmingDelete = false;
    public $roleToDelete;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage',
        'sortField',
        'sortDirection'
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function confirmDelete($roleId)
    {
        $this->confirmingDelete = true;
        $this->roleToDelete = $roleId;
    }

    public function deleteRole()
    {
        Role::find($this->roleToDelete)->delete();
        $this->confirmingDelete = false;
        session()->flash('message', 'Role deleted successfully.');
    }

    public function render()
    {
        return view('livewire.role.role-list', [
            'roles' => Role::with('permissions')
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage)
        ]);
    }
}
