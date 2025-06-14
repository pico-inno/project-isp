<?php

namespace App\Livewire\RadCheck;

use App\Models\RadAccPackage;
use App\Models\RadAcct;
use App\Models\RadCheck;
use App\Models\RadReply;
use App\Models\Router;
use App\Models\User;
use App\Traits\HandlesFlashMessages;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, HandlesFlashMessages;

    public $search = '';
    public $serviceType;

    public function mount($serviceType = null)
    {
        $this->serviceType = $serviceType;
    }

    public function deleteAccount($radCheckUsername)
    {
        if (!auth()->user()->hasPermissionTo('delete', 'User')) {
            $this->flashInfo('You are not authorized to delete user.');
        }else {
            $serviceTypeValue = $this->serviceType === 'pppoe' ? 'Framed-User' : 'Login-User';


            $hasCorrectServiceType = RadCheck::where('username', $radCheckUsername)
                ->where('attribute', 'Service-Type')
                ->where('value', $serviceTypeValue)
                ->exists();

            if ($hasCorrectServiceType) {
                RadCheck::where('username', $radCheckUsername)->delete();
                RadReply::where('username', $radCheckUsername)->delete();
                RadAccPackage::where('radcheck_username', $radCheckUsername)->delete();

                $this->flashSuccess('User deleted successfully.');
            } else {
                dd('fads');
                $this->flashError('User not found for this service type.');
            }

        }
    }

    public function render()
    {
        $radAcc = RadCheck::query()
            ->with('pppProfile')
            ->where('attribute', 'Cleartext-Password')
            ->when($this->serviceType === 'pppoe', function ($q) {
                $q->whereIn('username', function ($sub) {
                    $sub->select('username')
                        ->from('radcheck')
                        ->where('attribute', 'Service-Type')
                        ->where('value', 'Framed-User');
                });
            })
            ->when($this->serviceType === 'hotspot', function ($q) {
                $q->whereIn('username', function ($sub) {
                    $sub->select('username')
                        ->from('radcheck')
                        ->where('attribute', 'Service-Type')
                        ->where('value', 'Login-User');
                });
            })
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
