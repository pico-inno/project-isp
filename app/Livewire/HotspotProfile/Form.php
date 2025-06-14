<?php

namespace App\Livewire\HotspotProfile;

use App\Models\HotspotProfile;
use App\Traits\HandlesFlashMessages;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Form extends Component
{
    use HandlesFlashMessages;

    public $isEdit = false;
    public HotspotProfile $hotspotProfile;

    // Form fields
    public $name;
    public $address_pool;
    public $idle_timeout = '5m';
    public $keepalive_timeout = '2m';
    public $status_autorefresh = '1m';
    public $shared_users = 1;
    public $rate_limit;
    public $mac_cookie = false;
    public $http_cookie = false;
    public $session_timeout = '1h';

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:hotspot_profiles,name' . ($this->isEdit ? ',' . $this->hotspotProfile->id : '')],
            'address_pool' => ['nullable', 'string', 'max:255'],
            'idle_timeout' => ['required', 'string', 'max:20'],
            'keepalive_timeout' => ['required', 'string', 'max:20'],
            'status_autorefresh' => ['required', 'string', 'max:20'],
            'shared_users' => ['required', 'integer', 'min:1'],
            'rate_limit' => ['required', 'string', 'regex:/^\d+[KM]?\/\d+[KM]?$/'],
            'mac_cookie' => ['boolean'],
            'http_cookie' => ['boolean'],
            'session_timeout' => ['required', 'string', 'max:20'],
        ];
    }

    public function mount($hotspotProfile = null)
    {
        if ($hotspotProfile) {
            $this->hotspotProfile = $hotspotProfile;
            $this->isEdit = true;
            $this->fill($this->hotspotProfile->only([
                'name',
                'address_pool',
                'idle_timeout',
                'keepalive_timeout',
                'status_autorefresh',
                'shared_users',
                'rate_limit',
                'mac_cookie',
                'http_cookie',
                'session_timeout',
            ]));
        } else {
            $this->hotspotProfile = new HotspotProfile();
        }
    }

    public function save()
    {
        $this->validate();


        try {
            DB::transaction(function () {
                $this->hotspotProfile->fill([
                    'name' => $this->name,
                    'address_pool' => $this->address_pool,
                    'idle_timeout' => $this->idle_timeout,
                    'keepalive_timeout' => $this->keepalive_timeout,
                    'status_autorefresh' => $this->status_autorefresh,
                    'shared_users' => $this->shared_users,
                    'rate_limit' => $this->rate_limit,
                    'mac_cookie' => $this->mac_cookie,
                    'http_cookie' => $this->http_cookie,
                    'session_timeout' => $this->session_timeout,
                ])->save();
            });

            $this->flashSuccess($this->isEdit ? 'Profile updated successfully!' : 'Profile created successfully!');
            return $this->redirect(route('hotspot_profiles.index'), navigate: true);
        } catch (\Exception $e) {
            $this->flashError('Error saving profile: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.hotspot-profile.form');
    }

    public function placeholder()
    {
        return view('components.form-placeholder');
    }
}
