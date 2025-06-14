<?php

namespace App\Livewire\RadCheck;

use App\Models\HotspotProfile;
use App\Models\PppProfile;
use App\Models\RadAccPackage;
use App\Models\RadCheck;
use App\Models\RadReply;
use App\Traits\HandlesFlashMessages;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Form extends Component
{
    use HandlesFlashMessages;

    public $isEdit = false;
    public RadCheck $radCheck;

    public $username;
    public $value;
    public $selectedPackage;
    public $packages = [];
    public $serviceType;
    public $attribute;
    public $op;

    protected function rules()
    {
        return [
            'username' => 'required|string|max:255|unique:radcheck,username' . ($this->isEdit ? ',' . $this->radCheck->id : ''),
            'value' => 'required|string|min:6',
            'selectedPackage' => 'required|exists:' . ($this->serviceType === 'pppoe' ? 'ppp_profiles' : 'hotspot_profiles') . ',id',
        ];
    }

    public function mount($serviceType = null, $radCheck = null)
    {
        $this->serviceType = $serviceType;

        if ($this->serviceType === 'pppoe') {
            $this->packages = PppProfile::all();
        } elseif ($this->serviceType === 'hotspot') {
            $this->packages = HotspotProfile::all();
        }

        if ($radCheck) {
            $this->radCheck = $radCheck;
            $this->isEdit = true;
            $this->fill($this->radCheck->only(['username', 'attribute', 'op', 'value']));

            // Get current package from radreply
            $reply = RadReply::where('username', $this->radCheck->username)
                ->where('attribute', 'Mikrotik-Group')
                ->first();

            if ($reply) {
                if ($this->serviceType === 'pppoe') {
                    $this->selectedPackage = PppProfile::where('mikrotik_profile', $reply->value)
                        ->first()?->id;
                } elseif ($this->serviceType === 'hotspot') {
                    $this->selectedPackage = HotspotProfile::where('name', $reply->value)
                        ->first()?->id;
                }
            }
        } else {
            $this->radCheck = new RadCheck();
            $this->attribute = 'Cleartext-Password';
            $this->op = ':=';
        }
    }

    public function save()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                // Save password record
                $this->radCheck->fill([
                    'username' => $this->username,
                    'attribute' => $this->attribute,
                    'op' => $this->op,
                    'value' => $this->value,
                ])->save();

                // Set Service-Type
                $serviceTypeValue = match ($this->serviceType) {
                    'pppoe' => 'Framed-User',
                    'hotspot' => 'Login-User',
                    default => 'Framed-User'
                };

                RadCheck::updateOrCreate(
                    [
                        'username' => $this->username,
                        'attribute' => 'Service-Type',
                    ],
                    [
                        'op' => ':=',
                        'value' => $serviceTypeValue,
                    ]
                );

                // Get the selected package
                $package = $this->serviceType === 'pppoe'
                    ? PppProfile::find($this->selectedPackage)
                    : HotspotProfile::find($this->selectedPackage);

                // Save package reference
                RadAccPackage::updateOrCreate(
                    [
                        'radcheck_username' => $this->username,
                        'ppp_profiles_id' => $this->serviceType === 'pppoe' ? $package->id : null,
                        'hotspot_profiles_id' => $this->serviceType === 'hotspot' ? $package->id : null,
                    ],
                    [
                        'expires_at' => now()->addDays($package->validity_days),
                        'is_active' => true,
                    ]
                );

                // Set Mikrotik-Group
                RadReply::updateOrCreate(
                    [
                        'username' => $this->username,
                        'attribute' => 'Mikrotik-Group'
                    ],
                    [
                        'op' => ':=',
                        'value' => $this->serviceType === 'pppoe' ? $package->mikrotik_profile : $package->name
                    ]
                );

                // Set Session-Timeout
                RadReply::updateOrCreate(
                    [
                        'username' => $this->username,
                        'attribute' => 'Session-Timeout'
                    ],
                    [
                        'op' => ':=',
                        'value' => $package->validity_days * 86400
                    ]
                );

                // Set Rate Limit
                if ($this->serviceType === 'pppoe') {
                    RadReply::updateOrCreate(
                        [
                            'username' => $this->username,
                            'attribute' => 'Mikrotik-Rate-Limit'
                        ],
                        [
                            'op' => ':=',
                            'value' => "{$package->upload_speed}/{$package->download_speed}"
                        ]
                    );
                }
            });

            $this->flashSuccess($this->isEdit ? 'User Account updated successfully!' : 'User Account created successfully!');
            return $this->redirect(route('radcheck.index'), navigate: true);
        } catch (\Exception $e) {
            $this->flashError('Error saving account: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.rad-check.form');
    }

    public function placeholder()
    {
        return view('components.form-placeholder');
    }
}
