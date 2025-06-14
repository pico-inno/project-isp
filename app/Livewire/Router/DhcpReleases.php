<?php

namespace App\Livewire\Router;

use App\Models\Router;
use Livewire\Component;
use RouterOS\Client;
use RouterOS\Query;

class DhcpReleases extends Component
{
    public Router $router;
    public array $leases = [];

    public function mount(Router $router)
    {
        $this->router = $router;
        $this->fetchLeases();
    }

    protected function createClient(): Client
    {
        return new Client([
            'host'     => $this->router->host,
            'user'     => $this->router->username,
            'pass'     => $this->router->password,
            'port'     => (int) $this->router->port,
            'timeout'  => 5,
            'attempts' => 2,
        ]);
    }

    public function fetchLeases(): void
    {
        try {
            $client = $this->createClient();
            $query = new Query('/ip/dhcp-server/lease/print');
            $this->leases = $client->query($query)->read();
        } catch (\Exception $e) {
            $this->leases = [];
            session()->flash('error', 'Failed to fetch DHCP leases: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.router.dhcp-releases');
    }

    public function placeholder()
    {
        return view('components.table-placeholder');
    }
}
