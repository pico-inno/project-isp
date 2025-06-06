<?php

namespace App\Livewire\RadCheck;

use App\Models\RadAcct;
use App\Models\RadCheck;
use App\Models\Router;
use App\Models\User;
use App\Traits\HandlesFlashMessages;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, HandlesFlashMessages;

    public $search = '';
    public $router = null;

    public function mount(Router $router)
    {
        $this->router = $router;
    }

    public function deleteAccount($radAcctId)
    {
        if (!auth()->user()->hasPermissionTo('delete', 'User')) {
            $this->flashInfo('You are not authorized to delete user.');
        }else {
            $user = RadCheck::find($radAcctId);

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
        $radAcc = RadCheck::query()
            ->with('pppProfile')
            ->when($this->search, function ($query) {
                $query->where('username', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.rad-check.index', compact('radAcc'));
    }

    public function placeholder()
    {
        return view('components.table-placeholder');
    }
}
