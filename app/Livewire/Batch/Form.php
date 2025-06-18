<?php

namespace App\Livewire\Batch;

use App\Models\Batch;
use App\Models\BatchRadcheck;
use App\Models\RadCheck;
use App\Models\RadGroupCheck;
use App\Models\RadGroupReply;
use App\Models\RadUserGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class Form extends Component
{
    public $batch_name;
    public $hotspot_id = 0;
    public $batch_description;

    public $groups;

    public $number_of_instances = 4;
    public $account_type = 'random_username_and_passowrd';
    public $password_type = 'Cleartext-Password';
    public $username_prefix = '';
    public $availableGroups;
    public $selectedProfile;

    protected $rules = [
        'batch_name' => 'required|string|max:255',
//        'hotspot_id' => 'required|exists:hotspots,id',
        'batch_description' => 'nullable|string',
        'account_type' => 'required|string',
        'password_type' => 'required|string',
        'username_prefix' => 'nullable|string|max:50',
    ];

    public function mount()
    {
        $this->availableGroups = $this->getAllAvailableGroups();
    }

    protected function getAllAvailableGroups()
    {
        $userGroups = RadUserGroup::select('groupname')
            ->distinct()
            ->pluck('groupname')
            ->toArray();

        $checkGroups = RadGroupCheck::select('groupname')
            ->distinct()
            ->pluck('groupname')
            ->toArray();

        $replyGroups = RadGroupReply::select('groupname')
            ->distinct()
            ->pluck('groupname')
            ->toArray();


        $allGroups = array_unique(array_merge($userGroups, $checkGroups, $replyGroups));

        sort($allGroups);
        return array_combine($allGroups, $allGroups);
    }

    public function save()
    {
        $this->validate();

       DB::transaction(function () {
           $batch = Batch::create([
               'batch_name' => $this->batch_name,
               'batch_description' =>  $this->batch_description,
               'hotspot_id' =>  $this->hotspot_id,
               'batch_status' => 'Pending',
           ]);


           for ($i = 0; $i < $this->number_of_instances; $i++) {
               $username = $this->generateUsername($i);
               $password = $this->generatePassword();



               if ($this->account_type === 'random_voucher_code') {
                   $radCheckData = [
                       'username' => $password,
                       'attribute' => 'Auth-Type',
                       'op' => ':=',
                       'value' => 'Accept',
                   ];
               } else {
                   $radCheckData = [
                       'username' => $username,
                       'attribute' => 'Cleartext-Password',
                       'op' => ':=',
                       'value' => $password
                   ];
               }

               $radCheck = RadCheck::create($radCheckData);

               BatchRadcheck::create([
                   'batch_id' => $batch->id,
                   'radcheck_id' => $radCheck->id,
               ]);


               // group memberships
               RadUserGroup::where('username', $radCheck->username)->delete();


               RadUserGroup::create([
                   'username' => $radCheck->username,
                   'groupname' => $this->selectedProfile,
                   'priority' => 1
               ]);
           }
       });



        session()->flash('message', 'Batch created successfully! File is being processed.');
        return redirect()->route('batch.client-users.index');
    }

    protected function generateUsername($index)
    {
        $prefix = $this->username_prefix ?: '';

        switch ($this->account_type) {
            case 'incremental_username_and_passowrd':
                return $prefix . ($index + 1);

            case 'random_username_and_passowrd':
                return $prefix . Str::random(8);

            case 'random_voucher_code':
                return $prefix . Str::upper(Str::random(10));

            default:
                return $prefix . Str::random(8);
        }
    }

    protected function generatePassword()
    {
        if ($this->account_type === 'random_voucher_code') {
            return '';
        }

        return Str::random(8);
    }

    public function render()
    {
        return view('livewire.batch.form');
    }
}
