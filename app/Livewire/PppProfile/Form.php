<?php

namespace App\Livewire\PppProfile;

use App\Models\PppProfile;
use App\Models\Router;
use App\Traits\HandlesFlashMessages;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Form extends Component
{
    use HandlesFlashMessages;

    public $isEdit = false;
    public PppProfile $pppProfile;
    public $name;
    public $rate_limit;
    public $download_speed;
    public $upload_speed;
    public $validity_days = 30;
    public $price = 0;

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:ppp_profiles,name' . ($this->isEdit ? ',' . $this->pppProfile->id : ''),
            ],
            'rate_limit' => [
                'required',
                'regex:/^\d+[KMG]?\/\d+[KMG]?$/i', // accepts 15M/14M, 512K/512K
            ],
            'price' => [
                'required',
                'numeric',
            ],
            'validity_days' => [
                'required',
                'integer',
                'min:1',
            ],
        ];

    }

    public function mount($pppProfile = null)
    {
        if ($pppProfile) {
            $this->pppProfile = $pppProfile;
            $this->isEdit = true;
            $this->fill($this->pppProfile->only([
                'name', 'download_speed', 'upload_speed', 'validity_days', 'price'
            ]));
            $this->rate_limit = "{$this->download_speed}/{$this->upload_speed}";
        } else {
            $this->pppProfile = new PppProfile();
        }
    }

    public function updatedRateLimit()
    {
        if (strpos($this->rate_limit, '/') !== false) {
            [$download, $upload] = explode('/', $this->rate_limit);
            $this->download_speed = $download;
            $this->upload_speed = $upload;
        }
    }


    public function save()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                $this->pppProfile->fill([
                    'name' => $this->name,
                    'download_speed' => $this->download_speed,
                    'upload_speed' => $this->upload_speed,
                    'validity_days' => $this->validity_days,
                    'price' => $this->price,
                ])->save();
            });

            $this->flashSuccess($this->isEdit ? 'Profile updated successfully!' : 'Profile created successfully!');
            return $this->redirect(route('ppp_profiles.index'), navigate: true);
        } catch (\Exception $e) {
            $this->flashError('Error saving profile: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.ppp-profile.form');
    }

    public function placeholder()
    {
        return view('components.form-placeholder');
    }
}
