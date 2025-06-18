<?php

namespace App\Livewire\Profile;

use App\Models\PppProfile;
use App\Models\RadGroupCheck;
use App\Models\RadGroupReply;
use App\Models\Role;
use App\Models\Router;
use App\Traits\HandlesFlashMessages;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    use HandlesFlashMessages;

    public $search = '';

    public function mount()
    {

    }

    public function deletePackage($pppProfileId)
    {
        if (!auth()->user()->hasPermissionTo('delete', 'Profile')) {
            $this->flashInfo('You are not authorized to delete profile.');
        } else {
            try {
                $pppProfile = PppProfile::findOrFail($pppProfileId);

                $pppProfile->delete();

                $this->flashSuccess('Profile deleted successfully.');
            } catch (ModelNotFoundException $e) {
                $this->flashError('Profile not found.');
            } catch (\Exception $e) {
                $this->flashError('Error deleting profile: ' . $e->getMessage());
            }
        }
    }
    public function render()
    {
        $profiles = RadGroupCheck::select('groupname as name')
            ->groupBy('groupname')
            ->union(
                RadGroupReply::select('groupname as name')
                    ->groupBy('groupname')
            )
            ->orderBy('name')
            ->get()
            ->map(function ($item) {

                $checkCount = RadGroupCheck::where('groupname', $item->name)->count();
                $replyCount = RadGroupReply::where('groupname', $item->name)->count();

                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'total_attributes' => $checkCount + $replyCount,
                    'check_attributes' => $checkCount,
                    'reply_attributes' => $replyCount,
                ];
            });


        return view('livewire.profile.index', compact('profiles'));
    }

    public function placeholder()
    {
        return view('components.table-placeholder');
    }
}
