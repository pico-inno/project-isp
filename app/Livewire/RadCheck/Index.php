<?php

namespace App\Livewire\RadCheck;

use App\Models\RadAccPackage;
use App\Models\RadAcct;
use App\Models\RadCheck;
use App\Models\RadReply;
use App\Models\RadUserGroup;
use App\Models\Router;
use App\Models\User;
use App\Traits\HandlesFlashMessages;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, HandlesFlashMessages;

    public $search = '';
    public $serviceType;

    private $includeAttrivute;

    public function mount()
    {

    }

    public function deleteAccount($radCheckUsername)
    {
        if (!auth()->user()->hasPermissionTo('delete', 'User')) {
            $this->flashInfo('You are not authorized to delete user.');
        }else {
            RadCheck::where('username', $radCheckUsername)->delete();
            RadReply::where('username', $radCheckUsername)->delete();
            RadUserGroup::where('username', $radCheckUsername)->delete();

            $this->flashSuccess('User deleted successfully.');
        }
    }

    public function render()
    {
        $this->includeAttrivute = ['Auth-Type', 'MD5-Password', 'Cleartext-Password', 'SHA1-Password', 'Crypt-Password', 'NT-Password', 'User-Password', 'Calling-Station-Id'];
        $radAcc = RadCheck::query()
            ->whereIn('attribute',  $this->includeAttrivute)
            ->when($this->search, function ($query) {
                $query->where('username', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id')
            ->paginate(10);

        $radAcc->each(function ($radCheckItem) {
            $lastLogin = RadAcct::where('username', $radCheckItem->username)
                ->orderBy('AcctStartTime', 'desc')
                ->first();
            $groups = DB::table('radusergroup')
                ->where('username', $radCheckItem->username)
                ->pluck('groupname')
                ->implode(', ');


            $radCheckItem->groups = $groups;
            $radCheckItem->last_login_time = $lastLogin ? $lastLogin->AcctStartTime : null;
        });

        return view('livewire.rad-check.index', compact('radAcc'));
    }

    public function placeholder()
    {
        return view('components.table-placeholder');
    }
}
