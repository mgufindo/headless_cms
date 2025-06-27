<?php

namespace App\Livewire\Role;

use Livewire\Component;
use App\Models\Role;
use App\Models\Permission;

class EditPermissions extends Component
{
    public Role $role;
    public $selectedPermissions = [];

    protected $rules = [
        'selectedPermissions' => 'array',
    ];

    public function mount(Role $role)
    {
        $this->role = $role;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
    }

    public function save()
    {
        $this->validate();

        $this->role->permissions()->sync($this->selectedPermissions);

        session()->flash('message', 'Permissions updated successfully.');
        return redirect()->route('roles.index');
    }

    public function render()
    {
        $permissions = Permission::orderBy('name')->get();

        return view('livewire.role.edit-permissions', [
            'permissions' => $permissions
        ])->layout('layouts.app');
    }
}
