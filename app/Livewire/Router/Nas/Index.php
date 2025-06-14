<?php

namespace App\Livewire\Router\Nas;

use App\Models\Nas;
use App\Traits\HandlesFlashMessages;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, HandlesFlashMessages;

    public $search = '';
    public $perPage = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteNas($id)
    {
        $nas = Nas::find($id);
        if ($nas) {
            $nas->delete();
            $this->flashSuccess('Nas deleted successfully!');
        } else {
            session()->flash('flash.banner', 'Client Router not found!');
            $this->flashError('Nas not found!');
        }
    }

    public function render()
    {
        $query = Nas::query();

        if ($this->search) {
            $query->where('shortname', 'like', '%' . $this->search . '%')
                ->orWhere('nasname', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        $nases = $query->paginate($this->perPage);

        return view('livewire.router.nas.index', [
            'nases' => $nases,
        ]);
    }
}
