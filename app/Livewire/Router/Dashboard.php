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
    public $dataPoints =  [];

    public function mount(Router $router)
    {
        $this->router = $router;
        $this->connectAndLoadData();
    }

// Add these properties to your component
    public $currentRx = 0;
    public $currentTx = 0;
    public $avgRx = 0;
    public $avgTx = 0;
    public $peak = 0;

    protected function loadTrafficData(Client $client): void
    {
        try {
            $query = (new Query('/interface/monitor-traffic'))
                ->equal('interface', 'ether2')
                ->equal('once', '');

            $response = $client->query($query)->read();



            $currentTime = now()->format('H:i');
            $rxRate = ($response[0]['rx-bits-per-second'] ?? 0) / 1000; // Convert to kbps
            $txRate = ($response[0]['tx-bits-per-second'] ?? 0) / 1000; // Convert to kbps

            // Update current rates
            $this->currentRx = round($rxRate, 1);
            $this->currentTx = round($txRate, 1);

            // Add new data point
            $this->trafficData[] = [
                'time' => $currentTime,
                'rx' => $this->currentRx,
                'tx' => $this->currentTx
            ];

            // Keep only the last N data points
            if (count($this->trafficData) > $this->dataPoints) {
                $this->trafficData = array_slice($this->trafficData, -$this->dataPoints);
            }

            // Calculate averages and peak
            $this->calculateStats();

            // Dispatch event to update chart
            $this->dispatch('updateBandwidthChart', data: $this->getTrafficDataForChart());

        } catch (QueryException $e) {
            logger()->error('Failed to fetch traffic data: ' . $e->getMessage());
        }
    }

    protected function calculateStats(): void
    {
        if (empty($this->trafficData)) {
            return;
        }

        $rxValues = array_column($this->trafficData, 'rx');
        $txValues = array_column($this->trafficData, 'tx');
        $allValues = array_merge($rxValues, $txValues);

        $this->avgRx = round(array_sum($rxValues) / count($rxValues), 1);
        $this->avgTx = round(array_sum($txValues) / count($txValues), 1);
        $this->peak = round(max($allValues), 1);
    }

    public function getTrafficDataForChart(): array
    {
        if (empty($this->trafficData)) {
            return [
                'labels' => [],
                'rxData' => [],
                'txData' => []
            ];
        }

        return [
            'labels' => array_column($this->trafficData, 'time'),
            'rxData' => array_column($this->trafficData, 'rx'),
            'txData' => array_column($this->trafficData, 'tx')
        ];
    }

    public function placeholder()
    {
        return view('components.dashboard-placeholder', [
            'router' => $this->router
        ]);
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
            $this->isConnected = true;
        } catch (\Exception $e) {
            $this->connectionError = $this->formatErrorMessage($e);
            $this->isConnected = false;
        } finally {
            $this->isLoading = false;
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
}
