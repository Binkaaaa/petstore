<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class UserManagement extends Component
{
    public $users;

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = User::onlyUsers()->latest()->get();
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->user_type === 'user') {
            $user->delete();
            session()->flash('message', 'User deleted successfully.');
            $this->loadUsers(); // refresh the list
        }
    }
    
    public function render()
    {
        return view('livewire.admin.user-management');
    }
}
