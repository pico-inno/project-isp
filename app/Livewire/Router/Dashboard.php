<?php

namespace App\Livewire\Router;

use App\Models\Router;
use Livewire\Component;

class Dashboard extends Component
{
    public Router $router;

    public function mount($router)
    {

    }

    public function placeholder()
    {

    }


    public function render()
    {
        return view('livewire.router.dashboard');
    }
}
