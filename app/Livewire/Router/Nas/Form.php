<?php

namespace App\Livewire\Router\Nas;

use App\Models\Nas;
use App\Traits\HandlesFlashMessages;
use Livewire\Component;

class Form extends Component
{
    use HandlesFlashMessages;

    public bool $isEdit = false;
    public Nas $nas;

    // Form fields
    public $nasname;
    public $shortname;
    public $type = 'other';
    public $ports;
    public $secret;
    public $server;
    public $community;
    public $description;

    protected function rules()
    {
        return [
            'nasname' => 'required|ip',
            'shortname' => 'required|string|max:32',
            'type' => 'required|string|max:30',
            'ports' => 'nullable|numeric',
            'secret' => 'required|string|max:60',
            'server' => 'nullable|string|max:64',
            'community' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:200',
        ];
    }

    public function mount($nas = null)
    {
        if ($nas) {
            $this->nas = $nas;
            $this->isEdit = true;
            $this->fill($this->nas->only([
                'nasname',
                'shortname',
                'type',
                'ports',
                'secret',
                'server',
                'community',
                'description',
            ]));
        } else {
            $this->nas = new Nas();
        }
    }

    public function save()
    {
        $validated = $this->validate();

        try {
            $this->nas->fill($validated)->save();

            $this->flashSuccess($this->isEdit ? 'NAS updated successfully!' : 'NAS created successfully!');

            return $this->redirect(route('routers.nas.index'), navigate: true);
        } catch (\Exception $e) {
            $this->flashError('Error saving NAS: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.router.nas.form');
    }

    public function placeholder()
    {
        return view('components.form-placeholder');
    }
}
