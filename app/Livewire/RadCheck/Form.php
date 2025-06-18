<?php

namespace App\Livewire\RadCheck;

use App\Models\Dictionary;
use App\Models\HotspotProfile;
use App\Models\PppProfile;
use App\Models\RadAccPackage;
use App\Models\RadCheck;
use App\Models\RadGroupCheck;
use App\Models\RadGroupReply;
use App\Models\RadReply;
use App\Models\RadUserGroup;
use App\Traits\HandlesFlashMessages;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class Form extends Component
{
    use HandlesFlashMessages;

    public $isEdit = false;
    public RadCheck $radCheck;

    public $authenticationType = 'username_password'; // Default value
    public $passwordType = 'Cleartext-Password'; // Default value
    public $username;
    public $value;

    public $availableGroups;
    public $selectedProfile;
    public $attributesData = [];
    public $searchVendor = 'custom_attributes';
    public $dictionaryOptions = [];
    public $vendorOptions = [];

    protected $rules = [
        'authenticationType' => 'required|in:username_password,pin,mac',
        'username' => 'required|string|max:255',
        'value' => 'nullable|string|max:255',
        'passwordType' => 'required|in:Cleartext-Password,NT-Password,MD5-Password,SHA1-Password,User-Password,Crypt-Password,Auth-Type',
        'selectedProfile' => 'nullable',
    ];

    public function mount($radCheck = null)
    {

        $this->availableGroups = $this->getAllAvailableGroups();

        // Load vendor options
        $this->vendorOptions = Dictionary::select('vendor')
            ->whereNotNull('vendor')
            ->distinct()
            ->orderBy('vendor')
            ->pluck('vendor', 'vendor')
            ->toArray();
        if ($this->searchVendor) {
            $this->loadDictionaryOptions();
        }
        if (!$this->isEdit && empty($this->attributesData)) {
            $this->attributesData = [[
                'attribute' => '',
                'value' => '',
                'op' => ':=',
                'table' => 'check'
            ]];
        }

        if ($radCheck) {
            $this->isEdit = true;
            $this->radCheck = $radCheck;
            $this->username = $radCheck->username;
            $this->value = $radCheck->value;
            $this->passwordType = $radCheck->attribute;

            // Determine authentication type based on attribute
            if (str_contains($radCheck->attribute, 'Password')) {
                $this->authenticationType = 'username_password';
            } elseif ($radCheck->attribute === 'Auth-Types') {
                $this->authenticationType = 'pin';
            } elseif ($radCheck->attribute === 'Auth-Type') {
                $this->authenticationType = 'mac';
            }
            $this->loadAdditionalAttributes();

            $this->selectedProfile = RadUserGroup::where('username', $radCheck->username)->value('groupname');
        }
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

    protected function loadAdditionalAttributes()
    {

        $checkAttributes = RadCheck::where('username', $this->username)
            ->when($this->isEdit, function ($query) {
                $query->where('id', '!=', $this->radCheck->id ?? null);
            })
            ->get()
            ->map(function ($item) {
                return [
                    'attribute' => $item->attribute,
                    'value' => $item->value,
                    'op' => $item->op,
                    'table' => 'check'
                ];
            })->toArray();


        $replyAttributes = RadReply::where('username', $this->username)
            ->get()
            ->map(function ($item) {
                return [
                    'attribute' => $item->attribute,
                    'value' => $item->value,
                    'op' => $item->op,
                    'table' => 'reply'
                ];
            })->toArray();

        $this->attributesData = array_merge($checkAttributes, $replyAttributes);
    }

    public function loadDictionaryOptions()
    {
        $query = Dictionary::query();

        if ($this->searchVendor) {
            $query->where('vendor', $this->searchVendor);
        }

        $this->dictionaryOptions = $query
            ->orderBy('attribute')
            ->get()
            ->toArray();
    }


    public function updatedSearchVendor()
    {
        $this->loadDictionaryOptions();
    }

    public function addAttribute()
    {
        $this->attributesData[] = [
            'attribute' => '',
            'value' => '',
            'op' => ':=',
            'table' => 'check'
        ];
    }

    public function removeAttribute($index)
    {
        unset($this->attributesData[$index]);
        $this->attributesData = array_values($this->attributesData);
    }

    public function save()
    {
        $this->validate();



        try {
            DB::transaction(function () {
                $data = $this->prepareRadiusData();

                if ($this->isEdit) {
                    $this->radCheck->update($data);
                } else {
                    $this->radCheck = RadCheck::create($data);
                }

                RadCheck::where('username', $this->radCheck->username)
                    ->where('id', '!=', $this->radCheck->id)
                    ->delete();

                RadReply::where('username', $this->radCheck->username)
                    ->delete();

                // group memberships
                RadUserGroup::where('username', $this->radCheck->username)->delete();


                RadUserGroup::create([
                    'username' => $this->radCheck->username,
                    'groupname' => $this->selectedProfile,
                    'priority' => 1
                ]);


                // Save new attributes
                foreach ($this->attributesData as $attribute) {
                    if (!empty($attribute['attribute']) && !empty($attribute['value'])) {
                        $data = [
                            'username' => $this->radCheck->username,
                            'attribute' => $attribute['attribute'],
                            'op' => $attribute['op'],
                            'value' => $attribute['value'],
                        ];

                        if ($attribute['table'] === 'check') {
                            RadCheck::create($data);
                        } else {
                            RadReply::create($data);
                        }
                    }
                }

            });

            $this->flashSuccess($this->isEdit ? 'User Account updated successfully!' : 'User Account created successfully!');
            return $this->redirect(route('client-users.index'), navigate: true);
        } catch (\Exception $e) {
            $this->flashError('Error saving account: ' . $e->getMessage());
        }
    }

    private function prepareRadiusData(): array
    {
        return match ($this->authenticationType) {
            'username_password' => $this->prepareUsernamePasswordData(),
            'mac' => $this->prepareMacAuthData(),
            'pin' => $this->preparePinAuthData(),
            default => throw new \InvalidArgumentException("Unsupported authentication type"),
        };
    }

    private function prepareUsernamePasswordData(): array
    {
        $data = [
            'username' => $this->username,
            'attribute' => $this->passwordType,
            'op' => ':=',
        ];

        if (!$this->isEdit) {
            $data['value'] = $this->processPasswordValue($this->passwordType, $this->value);
        }

        return $data;
    }

    private function prepareMacAuthData(): array
    {
        $normalizedMac = strtolower(str_replace(['-', ':', ' '], '', $this->username));
        $formattedMac = wordwrap($normalizedMac, 2, ':', true);

        return [
            'username' => $formattedMac,
            'attribute' => 'Auth-Type',
            'op' => ':=',
            'value' => 'Accept',
        ];
    }

    private function preparePinAuthData(): array
    {
        return [
            'username' => $this->username,
            'attribute' => 'Auth-Type',
            'op' => ':=',
            'value' => 'Accept',
        ];
    }

    protected function processPasswordValue($passwordType, $plainPassword)
    {
        return match($passwordType) {
            'Cleartext-Password' => $plainPassword, // Stored in plain text
            'MD5-Password' => hash('md5', $plainPassword),
            'SHA1-Password' => hash('sha1', $plainPassword),
            'Crypt-Password' => crypt($plainPassword, '$1$' . Str::random(8)), // Using MD5 crypt
            'NT-Password' => strtoupper(bin2hex(mhash(MHASH_MD4, iconv('UTF-8', 'UTF-16LE', $plainPassword)))),
            'User-Password' => $plainPassword, // Typically same as Cleartext
            default => $plainPassword,
        };
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
