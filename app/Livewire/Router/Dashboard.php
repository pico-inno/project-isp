<?php

namespace App\Livewire\Router;

use App\Models\Router;
use Livewire\Component;
use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Exceptions\ClientException;
use RouterOS\Exceptions\ConfigException;
use RouterOS\Exceptions\QueryException;
use RouterOS\Query;

class Dashboard extends Component
{
    public Router $router;
    public array $systemInfo = [];
    public array $interfaces = [];
    public bool $isConnected = false;
    public ?string $connectionError = null;
    public bool $isLoading = true;
    public $trafficData =  [];

    public $currentRx = 0;
    public $currentTx = 0;
    public $activePppoe = [];
    public $targetInterface = 'ether2';

    public function mount(Router $router)
    {
        $this->router = $router;
        $this->connectAndLoadData();
    }

    public function retryConnection()
    {
        $this->isLoading = true;
        $this->connectionError = null;
        $this->connectAndLoadData();
    }

    public function connectAndLoadData()
    {
        try {
            $client = $this->createClient();
            $this->loadSystemInfo($client);
            $this->loadInterfaces($client);
            $this->loadTrafficData($client);
            $this->getLastActivePppoeConnections($client);

            $this->isConnected = true;
        } catch (\Exception $e) {
            $this->connectionError = $this->formatErrorMessage($e);
            $this->isConnected = false;
        } finally {
            $this->isLoading = false;
        }
    }

    protected function loadTrafficData(Client $client): void
    {
        try {
            $query = (new Query('/interface/monitor-traffic'))
                ->equal('interface', $this->targetInterface)
                ->equal('once', '');

            $response = $client->query($query)->read();


            $currentTime = now()->format('H:i:s');

            $rxRate = ($response[0]['rx-bits-per-second'] ?? 0) / 1000;
            $txRate = ($response[0]['tx-bits-per-second'] ?? 0) / 1000;

            $this->currentRx = round($rxRate, 1);
            $this->currentTx = round($txRate, 1);

            $this->trafficData[] = [
                'time' => $currentTime,
                'rx' => $this->currentRx,
                'tx' => $this->currentTx
            ];

        } catch (QueryException $e) {
            logger()->error('Failed to fetch traffic data: ' . $e->getMessage());
        }
    }

    protected function getLastActivePppoeConnections(Client $client)
    {
        try {
            $query = (new Query('/ppp/active/print'))
                ->where('service', 'pppoe');

            $response = $client->query($query)->read();

            // Sort by uptime (most recent first) and get last 6
            usort($response, function($a, $b) {
                return strtotime($b['uptime']) - strtotime($a['uptime']);
            });

            $this->activePppoe =  array_slice($response, 0, 6);
        } catch (\Exception $e) {
            logger()->error('Failed to fetch PPPoE connections: ' . $e->getMessage());
            return [];
        }
    }

    protected function createClient(): Client
    {
        try {
            return new Client([
                'host' => $this->router->host,
                'user' => $this->router->username,
                'pass' => $this->router->password,
                'port' => (int)$this->router->port,
                'timeout' => 5, // 5 second timeout
            ]);
        } catch (ConfigException $e) {
            throw new \RuntimeException("Invalid router configuration: " . $e->getMessage());
        }
    }

    protected function loadSystemInfo(Client $client): void
    {
        try {
            $response = $client->query('/system/resource/print')->read();
            $this->systemInfo = $response[0] ?? [];
        } catch (QueryException $e) {
            throw new \RuntimeException("Failed to fetch system info: " . $e->getMessage());
        }
    }

    protected function loadInterfaces(Client $client): void
    {
        try {
            $response = $client->query('/interface/print')->read();
            $this->interfaces = $response;
        } catch (QueryException $e) {
            throw new \RuntimeException("Failed to fetch interfaces: " . $e->getMessage());
        }
    }

    protected function formatErrorMessage(\Exception $e): string
    {
        if ($e instanceof ClientException) {
            return "Connection failed. Please check the router credentials and network connectivity.";
        }

        return "Error: " . $e->getMessage();
    }

    public function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function formatUptime(): string
    {
        $uptime = $this->systemInfo['uptime'] ?? null;

        if (!is_numeric($uptime)) {
            return 'N/A';
        }

        $seconds = (int) $uptime;
        $days = floor($seconds / 86400);
        $hours = floor(($seconds % 86400) / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        return sprintf('%d days, %d hours, %d minutes', $days, $hours, $minutes);
    }


    public function render()
    {
        return view('livewire.router.dashboard');
    }

    public function placeholder()
    {
        return view('components.dashboard-placeholder', [
            'router' => $this->router
        ]);
    }
}
