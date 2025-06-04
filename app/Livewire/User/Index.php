<?php

namespace App\Livewire\User;

use App\Traits\HandlesFlashMessages;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class Index extends Component
{
    use WithPagination, HandlesFlashMessages;

    public $search = '';

    public function mount(){
        //continue
    }

    public function createUser(){
        return redirect()->route('users.create');
    }

    public function editUser($userId){
        return redirect()->route('users.edit', $userId);
    }
    public function deleteUser($userId)
    {
        if (!auth()->user()->hasPermissionTo('delete', 'User')) {
            $this->flashInfo('You are not authorized to delete user.');
        }else {
            $user = User::find($userId);

            if ($user) {
                $user->delete();
                $this->flashSuccess('User deleted successfully.');
            } else {
                $this->flashError('User not found.');
            }
        }
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.user.index', compact('users'));
    }

    public function placeholder()
    {
        return view('components.table-placeholder');
    }
}
