<?php

namespace App\Livewire\PppProfile;

use App\Models\PppProfile;
use App\Models\Router;
use App\Traits\HandlesFlashMessages;
use Livewire\Component;

class Index extends Component
{
    use HandlesFlashMessages;

    public $search = '';
    public $router = null;

    public function mount(Router $router)
    {
        $this->router = $router;
    }

    public function render()
    {
        $profiles = PppProfile::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.ppp-profile.index', compact('profiles'));
    }

    public function placeholder()
    {
        return view('components.table-placeholder');
    }
}
