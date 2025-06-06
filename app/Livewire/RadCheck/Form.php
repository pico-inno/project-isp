<?php

namespace App\Livewire\RadCheck;

use App\Models\PppProfile;
use App\Models\RadAcct;
use App\Models\RadCheck;
use App\Models\RadReply;
use App\Models\Router;
use App\Traits\HandlesFlashMessages;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Form extends Component
{
    use HandlesFlashMessages;

    public $isEdit = false;
    public RadCheck $radCheck;
    public $accountId;
    public $routerId;
    public $router;

    public $username;
    public $value;
    public $selectedPackage;
    public $packages = [];

    protected function rules()
    {
        return [
            'username' => 'required|string|max:255|unique:radcheck,username' . ($this->isEdit ? ',' . $this->radCheck->id : ''),
            'value' => 'required|string|min:6',
            'selectedPackage' => 'required|exists:ppp_profiles,id',
        ];
    }

    public function mount(Router $router, $radCheck = null)
    {
        $this->router = $router;
        $this->routerId = $this->router->id;
        $this->packages = PppProfile::all();

        if ($radCheck) {
            $this->radCheck = $radCheck;
            $this->isEdit = true;
            $this->fill($this->radCheck->only(['username', 'attribute', 'op', 'value']));

            // Get current package from radreply
            $reply = RadReply::where('username', $this->radCheck->username)
                ->where('attribute', 'Mikrotik-Group')
                ->first();

            if ($reply) {
                $this->selectedPackage = PppProfile::where('mikrotik_profile', $reply->value)
                    ->first()?->id;
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

                $this->radCheck->fill([
                    'username' => $this->username,
                    'attribute' => 'Cleartext-Password',
                    'op' => ':=',
                    'value' => $this->value,
                ])->save();


                $package = PppProfile::find($this->selectedPackage);



                RadReply::updateOrCreate(
                    [
                        'username' => $this->username,
                        'attribute' => 'Mikrotik-Rate-Limit'
                    ],
                    [
                        'op' => ':=',
                        'value' => $package->mikrotik_profile
                    ]
                );

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
            });

            $this->flashSuccess($this->isEdit ? 'User Account updated successfully!' : 'User Account created successfully!');
            return $this->redirect(route('radcheck.index', ['router' => $this->routerId]), navigate: true);
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
