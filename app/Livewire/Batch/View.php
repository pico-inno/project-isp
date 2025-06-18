<?php

namespace App\Livewire\Batch;

use App\Models\Batch;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class View extends Component
{
    public Batch $batch;
    public $userAccounts = [];

    public function mount($batch)
    {
        $this->userAccounts = $this->batch->radcheckAccounts->map(function ($account) {
            $groups = DB::table('radusergroup')
                ->where('username', $account->username)
                ->pluck('groupname')
                ->implode(', ');

            return [
                'username' => $account->username,
                'password' => $account->value,
                'groups' => $groups ?: 'None',
                'created_at' => now()
            ];
        });
    }

    public function render()
    {
        return view('livewire.batch.view');
    }
}
