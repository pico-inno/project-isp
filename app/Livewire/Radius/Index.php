<?php

namespace App\Livewire\Radius;

use App\Models\Router;
use App\Traits\HandlesFlashMessages;
use Livewire\Component;
use RouterOS\Client;
use RouterOS\Query;

class Index extends Component
{
    use HandlesFlashMessages;

    public $radiusServers = [];
    public $isLoading = false;
    public $router = null;

    public function mount(Router $router)
    {
        $this->router = $router;
        $this->fetchRadiusData();
    }


    public function fetchRadiusData()
    {
        $this->isLoading = true;
        $this->radiusServers = [];

        try {

            if (!$this->router) {
                throw new \Exception('No router configured.');
            }

            $client = new Client([
                'host' => $this->router->host,
                'user' => $this->router->username,
                'pass' => $this->router->password,
                'port' => $this->router->port ?? 8728,
            ]);

            $query = new Query('/radius/print');
            $this->radiusServers = $client->query($query)->read();

        } catch (\Exception $e) {
            $this->flashError('Failed to fetch RADIUS data: ' . $e->getMessage());
        }

        $this->isLoading = false;
    }


    public function deleteRadiusServer($id)
    {
        $this->isLoading = true;

        try {
            if (!$this->router) {
                throw new \Exception('No router configured.');
            }

            $client = new Client([
                'host' => $this->router->host,
                'user' => $this->router->username,
                'pass' => $this->router->password,
                'port' => $this->router->port ?? 8728,
            ]);

            $query = (new Query('/radius/remove'))
                ->equal('.id', $id);

            $client->query($query)->read();
            $this->fetchRadiusData();
            sleep(1);
            $this->flashSuccess('Radius server deleted from '. $this->router->name.'('.$this->router->host.')');
        } catch (\Exception $e) {
            $this->flashError('Failed to delete RADIUS server: ' . $e->getMessage());
        }

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.radius.index');
    }

    public function placeholder()
    {
        return view('components.table-placeholder');
    }
}
