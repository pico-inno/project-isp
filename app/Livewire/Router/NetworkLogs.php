<?php

namespace App\Livewire\Router;

use App\Models\Router;
use Livewire\Component;
use RouterOS\Client;
use RouterOS\Query;
use RouterOS\Exceptions\ConfigException;
use RouterOS\Exceptions\QueryException;
use Illuminate\Support\Facades\Log;

class NetworkLogs extends Component
{
    public $hotspotLogs = [];
    public $pppoeLogs = [];
    public $logType = 'hotspot'; // Default to show hotspot logs
    public $search = '';
    public $logCount = 50;
    public $router;
    public $isLoading = false;

    public function mount(Router $router)
    {
        $this->router = $router;
        $this->fetchLogs();
    }

    public function fetchLogs()
    {
        $this->isLoading = true;

        try {
            $client = $this->createClient();

            if ($this->logType === 'hotspot') {
                $this->hotspotLogs = $this->getHotspotLogs($client);
            } else {
                $this->pppoeLogs = $this->getPppoeLogs($client);
            }

        } catch (\Exception $e) {
            Log::error("Failed to fetch logs from router {$this->router->id}: " . $e->getMessage());
            $this->addError('connection', 'Failed to connect to router: ' . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    protected function getHotspotLogs(Client $client): array
    {
        try {
            $query = (new Query('/log/print'))
                ->where('topics', 'hotspot');

            $response = $client->query($query)->read();

            return array_map(function($entry) {
                return sprintf(
                    "[%s] %s: %s",
                    date('Y-m-d H:i:s', strtotime($entry['time'])),
                    strtoupper($entry['topics']),
                    $entry['message']
                );
            }, $response);

        } catch (QueryException $e) {
            Log::error("Hotspot log query failed: " . $e->getMessage());
            return ["Error fetching hotspot logs: " . $e->getMessage()];
        }
    }

    protected function getPppoeLogs(Client $client): array
    {
        try {
            $query = (new Query('/log/print'))
                ->where('topics', 'pppoe');

            $response = $client->query($query)->read();

            return array_map(function($entry) {
                return sprintf(
                    "[%s] %s: %s",
                    date('Y-m-d H:i:s', strtotime($entry['time'])),
                    strtoupper($entry['topics']),
                    $entry['message']
                );
            }, $response);

        } catch (QueryException $e) {
            Log::error("PPPoE log query failed: " . $e->getMessage());
            return ["Error fetching PPPoE logs: " . $e->getMessage()];
        }
    }

    public function updatedLogType()
    {
        $this->fetchLogs();
    }

    public function refreshLogs()
    {
        $this->fetchLogs();
    }

    protected function createClient(): Client
    {
        try {
            return new Client([
                'host' => $this->router->host,
                'user' => $this->router->username,
                'pass' => $this->router->password,
                'port' => (int)$this->router->port,
                'timeout' => 5,
                'attempts' => 2,
            ]);
        } catch (ConfigException $e) {
            throw new \RuntimeException("Invalid router configuration: " . $e->getMessage());
        }
    }

    public function render()
    {
        $logs = $this->logType === 'hotspot' ? $this->hotspotLogs : $this->pppoeLogs;

        // Apply search filter
        if (!empty($this->search)) {
            $logs = array_filter($logs, function($log) {
                return stripos($log, $this->search) !== false;
            });
        }

        // Limit the number of logs shown
        $logs = array_slice($logs, 0, $this->logCount);

        return view('livewire.router.network-logs', [
            'logs' => $logs,
            'logCount' => count($logs),
            'isLoading' => $this->isLoading,
        ]);
    }

    public function placeholder()
    {
        return view('components.table-placeholder');
    }
}
