<?php

namespace App\Livewire\Attribute;

use App\Traits\HandlesFlashMessages;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Dictionary;

class Index extends Component
{
    use WithPagination, HandlesFlashMessages;

    public $search = '';

    public function render()
    {
        $attributes = Dictionary::when($this->search, function ($query) {
            return $query->where(function ($q) {
                $q->where('attribute', 'like', '%'.$this->search.'%')
                    ->orWhere('vendor', 'like', '%'.$this->search.'%');
            });
        })
        ->orderByRaw("vendor REGEXP '^[0-9]'")
        ->orderBy('vendor')
        ->paginate(10);

        return view('livewire.attribute.index', compact('attributes'));
    }

    public function deleteAttribute($id)
    {
        Dictionary::findOrFail($id)->delete();
        $this->flashSuccess('Attribute deleted successfully.');
    }
}
