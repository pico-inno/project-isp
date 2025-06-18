<?php

namespace App\Livewire\Profile;

use App\Models\Dictionary;
use App\Models\RadCheck;
use App\Models\RadGroupCheck;
use App\Models\RadGroupReply;
use App\Models\RadReply;
use App\Traits\HandlesFlashMessages;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Form extends Component
{
    use HandlesFlashMessages;

    public $isEdit = false;
    public ?RadGroupCheck $radGroupCheck = null;

    public $name;
    public $vendorOptions = [];
    public $attributesData = [];
    public $dictionaryOptions = [];
    public $searchVendor = 'custom_attributes';

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $query = RadGroupCheck::where('groupname', $value);

                    if ($this->isEdit) {
                        $query->where('groupname', '!=', $this->radGroupCheck->groupname);
                    }

                    if ($query->exists()) {
                        $fail('The profile name has already been taken.');
                    }
                }
            ],
            'attributesData.*.attribute' => 'required|string|max:255',
            'attributesData.*.value' => 'required|string|max:255',
            'attributesData.*.op' => 'required|string|max:2',
            'attributesData.*.table' => 'required|in:check,reply',
        ];
    }

    public function mount($profile = null)
    {
        if ($profile) {
            $this->radGroupCheck = RadGroupCheck::where('groupname', $profile)->first();
            $this->isEdit = true;
            $this->loadExistingAttributes();
        }

        if ($this->isEdit) {
            $this->name = $this->radGroupCheck->groupname;
            if ($this->searchVendor) {
                $this->loadDictionaryOptions();
            }
        }

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


    protected function loadExistingAttributes()
    {
        $checkAttributes = RadGroupCheck::where('groupname', $this->radGroupCheck->groupname)
            ->get()
            ->map(function ($item) {
                return [
                    'attribute' => $item->attribute,
                    'value' => $item->value,
                    'op' => $item->op,
                    'table' => 'check'
                ];
            })->toArray();


        $replyAttributes = RadGroupReply::where('groupname', $this->radGroupCheck->groupname)
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

//        if ($this->searchVendor && $this->searchVendor !== 'custom_attributes') {
//            $query->where('vendor', $this->searchVendor);
//        }

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
                $groupName = $this->name;

                if ($this->isEdit) {
                    // Delete existing attributes if editing
                    RadGroupCheck::where('groupname', $this->radGroupCheck->groupname)->delete();
                    RadGroupReply::where('groupname', $this->radGroupCheck->groupname)->delete();
                }

                // Save new attributes
                foreach ($this->attributesData as $attribute) {
                    if ($attribute['table'] === 'check') {
                        RadGroupCheck::create([
                            'groupname' => $groupName,
                            'attribute' => $attribute['attribute'],
                            'op' => $attribute['op'],
                            'value' => $attribute['value']
                        ]);
                    } else {
                        RadGroupReply::create([
                            'groupname' => $groupName,
                            'attribute' => $attribute['attribute'],
                            'op' => $attribute['op'],
                            'value' => $attribute['value']
                        ]);
                    }
                }
            });

            $this->flashSuccess($this->isEdit ? 'Profile updated successfully!' : 'Profile created successfully!');
            return $this->redirect(route('profiles.index'), navigate: true);
        } catch (\Exception $e) {
            $this->flashError('Error saving profile: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.profile.form');
    }
}
