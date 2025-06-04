<?php

namespace App\Livewire\Router;

use App\Models\Role;
use App\Models\Router;
use App\Traits\HandlesFlashMessages;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, HandlesFlashMessages;

    public $search = '';

    public function mount(){
        //continue
    }

    public function createRouter()
    {
        return $this->redirect(route('routers.create'), navigate: true);
    }


    public function editRouter($routerId)
    {
        return $this->redirect(route('routers.edit', $routerId), navigate: true);
    }

    public function connectToRouter($routerId)
    {
        return $this->redirect(route('routers.dashboard', $routerId), navigate: true);
    }

    public function deleteRouter($routerId)
    {
        if (!auth()->user()->hasPermissionTo('delete', 'Router')) {
            $this->flashInfo('You are not authorized to delete router.');
        }else {
            $user = Router::find($routerId);

            if ($user) {
                $user->delete();
                $this->flashSuccess('Router removed successfully.');
            } else {
                $this->flashError('Router not found.');
            }
        }
        return $this->redirect(route('routers.index', $routerId), navigate: true);
    }

    public function render()
    {
        $routers = Router::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
        return view('livewire.router.index', compact('routers'));
    }

    public function placeholder()
    {
        return view('components.table-placeholder');
    }
}
