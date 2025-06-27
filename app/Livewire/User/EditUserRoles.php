<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;

class EditUserRoles extends Component
{
    public User $user;
    public $availableRoles;
    public $userRoles = [];

    protected $rules = [
        'userRoles' => 'array',
    ];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->availableRoles = Role::all();
        $this->userRoles = $user->roles->pluck('id')->toArray();
    }

    public function save()
    {
        $this->validate();

        // Sync user roles
        $this->user->roles()->sync($this->userRoles);

        session()->flash('message', 'Roles updated successfully.');
        $this->emit('rolesUpdated');
    }

    public function render()
    {
        return view('livewire.user.edit-user-roles');
    }
}
