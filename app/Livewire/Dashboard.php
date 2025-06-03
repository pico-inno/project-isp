<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public int $totalUsers = 0;
    public int $totalRoles = 0;
    public int $newUsersThisMonth = 0;
    public int $newRolesThisMonth = 0;

    public function mount()
    {
        $this->loadStats();
    }

    protected function loadStats()
    {
        $this->totalUsers = User::count();
        $this->totalRoles = Role::count();

        // Calculate new users/roles this month
        $this->newUsersThisMonth = User::where('created_at', '>=', now()->startOfMonth())->count();
        $this->newRolesThisMonth = Role::where('created_at', '>=', now()->startOfMonth())->count();
    }

    public function placeholder()
    {
        return view('components.dashboard-skeleton');
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
