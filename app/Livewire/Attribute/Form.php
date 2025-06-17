<?php

namespace App\Livewire\Attribute;

use Livewire\Component;
use App\Models\Dictionary;

class Form extends Component
{
    public $attribute;
    public $isEdit = false;

    // Form fields
    public $type;
    public $attribute_name;
    public $value;
    public $format;
    public $vendor;
    public $recommended_op;
    public $recommended_table;
    public $recommended_helper;
    public $recommended_tooltip;

    protected $rules = [
        'type' => 'required|string|max:255',
        'attribute_name' => 'required|string|max:255',
        'value' => 'required|string|max:255',
        'format' => 'nullable|string|max:255',
        'vendor' => 'nullable|string|max:255',
        'recommended_op' => 'nullable|string|max:255',
        'recommended_table' => 'nullable|string|max:255',
        'recommended_helper' => 'nullable|string|max:255',
        'recommended_tooltip' => 'nullable|string',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->attribute = Dictionary::findOrFail($id);
            $this->isEdit = true;

            // Populate form fields
            $this->type = $this->attribute->type;
            $this->attribute_name = $this->attribute->attribute;
            $this->value = $this->attribute->value;
            $this->format = $this->attribute->format;
            $this->vendor = $this->attribute->vendor;
            $this->recommended_op = $this->attribute->recommended_OP;
            $this->recommended_table = $this->attribute->recommended_table;
            $this->recommended_helper = $this->attribute->recommended_helper;
            $this->recommended_tooltip = $this->attribute->recommended_tooltip;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'type' => $this->type,
            'attribute' => $this->attribute_name,
            'value' => $this->value,
            'format' => $this->format,
            'vendor' => $this->vendor,
            'recommended_OP' => $this->recommended_op,
            'recommended_table' => $this->recommended_table,
            'recommended_helper' => $this->recommended_helper,
            'recommended_tooltip' => $this->recommended_tooltip,
        ];

        if ($this->isEdit) {
            $this->attribute->update($data);
            session()->flash('message', 'Attribute updated successfully.');
        } else {
            Dictionary::create($data);
            session()->flash('message', 'Attribute created successfully.');
        }

        return redirect()->route('attributes.index');
    }

    public function render()
    {
        return view('livewire.attribute.form');
    }
}
