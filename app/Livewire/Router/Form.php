<?php

namespace App\Livewire\Router;

use App\Traits\HandlesFlashMessages;
use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\Router;

class Form extends Component
{
    use HandlesFlashMessages;

    public bool $isEdit = false;
    public Router $router;

    // Form fields
    public string $name = '';
    public string $host = '';
    public string $port = '8728';
    public string $username = 'admin';
    public string $password = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'host' => 'required',
            'port' => 'required|numeric|min:1|max:65535',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ];
    }

    public function mount($router= null)
    {
        if ($router) {
            $this->router = $router;
            $this->isEdit = true;
            $this->fill($this->router->only([
                'name', 'host', 'port', 'username',
                'password', 'description', 'encryption'
            ]));
        } else {
            $this->router = new Router();
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $this->router->fill([
                'name' => $this->name,
                'host' => $this->host,
                'port' => $this->port,
                'username' => $this->username,
                'password' => $this->password,
            ])->save();

            $this->flashSuccess( $this->isEdit ? 'Router updated successfully!' : 'Router created successfully!');

            return $this->redirect(route('routers.index'), navigate: true);
        } catch (\Exception $e) {
            $this->flashError('Error saving router: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.router.form');
    }
}
