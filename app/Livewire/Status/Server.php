<?php

namespace App\Livewire\Status;

use Livewire\Component;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;

class Server extends Component
{
    public $systemInfo = [];
    public $lastUpdated;
    public $isLoading = true;
    public $error = null;

    protected $listeners = ['refreshServerStatus' => 'loadData'];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->isLoading = true;
        $this->error = null;

        try {
            // General Information
            $this->systemInfo['distro'] = $this->getDistroInfo();
            $this->systemInfo['uptime'] = $this->getUptime();
            $this->systemInfo['load'] = $this->getLoadAverage();
            $this->systemInfo['tasks'] = $this->getTaskStats();
            $this->systemInfo['cpu'] = $this->getCpuUsage();
            $this->systemInfo['hostname'] = gethostname();
            $this->systemInfo['date'] = now()->format('F j, Y, g:i a');

            // Memory Information
            $this->systemInfo['memory'] = $this->getMemoryInfo();

            // Disk Information
            $this->systemInfo['disk'] = $this->getDiskSpace();

            // Network Information
            $this->systemInfo['network'] = $this->getNetworkInfo();

            $this->lastUpdated = now()->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            $this->error = "Failed to retrieve server information: " . $e->getMessage();
        }

        $this->isLoading = false;
    }

    private function getDistroInfo(): string
    {
        if (file_exists('/etc/os-release')) {
            $osRelease = file_get_contents('/etc/os-release');
            if (preg_match('/PRETTY_NAME="(.+)"/', $osRelease, $matches)) {
                return $matches[1];
            }
        }
        return 'Linux';
    }

    private function getUptime(): string
    {
        $uptime = file_get_contents('/proc/uptime');
        $uptime = floatval(explode(' ', $uptime)[0]);

        $days = floor($uptime / 86400);
        $hours = floor(($uptime % 86400) / 3600);
        $minutes = floor(($uptime % 3600) / 60);

        return sprintf('%d days %d hours %d minutes', $days, $hours, $minutes);
    }

    private function getLoadAverage(): array
    {
        $load = sys_getloadavg();
        return [
            '1min' => $load[0],
            '5min' => $load[1],
            '15min' => $load[2]
        ];
    }

    private function getTaskStats(): array
    {
        $result = Process::run('ps -e --no-headers | wc -l');
        $total = trim($result->output());

        $result = Process::run('ps -e --no-headers -o stat | grep -c "^R"');
        $running = trim($result->output());

        return [
            'total' => $total,
            'running' => $running,
            'sleeping' => $total - $running // Simplified
        ];
    }

    private function getCpuUsage(): array
    {
        $stat1 = file('/proc/stat');
        sleep(1);
        $stat2 = file('/proc/stat');

        $info1 = explode(" ", preg_replace("!cpu +!", "", $stat1[0]));
        $info2 = explode(" ", preg_replace("!cpu +!", "", $stat2[0]));

        $dif = [];
        $dif['user'] = $info2[0] - $info1[0];
        $dif['nice'] = $info2[1] - $info1[1];
        $dif['sys'] = $info2[2] - $info1[2];
        $dif['idle'] = $info2[3] - $info1[3];
        $total = array_sum($dif);

        return [
            'user' => round($dif['user'] / $total * 100, 1),
            'sys' => round($dif['sys'] / $total * 100, 1),
            'idle' => round($dif['idle'] / $total * 100, 1)
        ];
    }

    private function getMemoryInfo(): array
    {
        $meminfo = file('/proc/meminfo');
        $mem = [];

        foreach ($meminfo as $line) {
            if (preg_match('/^MemTotal:\s+(\d+)\s+kB/i', $line, $matches)) {
                $mem['total'] = round($matches[1] / 1024, 2);
            }
            if (preg_match('/^MemFree:\s+(\d+)\s+kB/i', $line, $matches)) {
                $mem['free'] = round($matches[1] / 1024, 2);
            }
            if (preg_match('/^MemAvailable:\s+(\d+)\s+kB/i', $line, $matches)) {
                $mem['available'] = round($matches[1] / 1024, 2);
            }
        }

        $mem['used'] = $mem['total'] - $mem['available'];
        $mem['percent'] = round(($mem['used'] / $mem['total']) * 100, 1);

        return $mem;
    }

    private function getDiskSpace(): array
    {
        $total = disk_total_space('/');
        $free = disk_free_space('/');
        $used = $total - $free;

        return [
            'total' => round($total / (1024 * 1024 * 1024), 2),
            'free' => round($free / (1024 * 1024 * 1024), 2),
            'used' => round($used / (1024 * 1024 * 1024), 2),
            'percent' => round(($used / $total) * 100, 1)
        ];
    }

    private function getNetworkInfo(): array
    {
        $interfaces = [];
        $result = Process::run('ip -o addr show');
        $lines = explode("\n", trim($result->output()));

        foreach ($lines as $line) {
            $parts = preg_split('/\s+/', $line);
            $interface = $parts[1];

            if (!isset($interfaces[$interface])) {
                $interfaces[$interface] = [
                    'name' => $interface,
                    'ip' => '',
                    'mac' => '',
                    'state' => 'down'
                ];
            }

            if ($parts[2] === 'inet') {
                $interfaces[$interface]['ip'] = explode('/', $parts[3])[0];
            } elseif ($parts[2] === 'link/ether') {
                $interfaces[$interface]['mac'] = $parts[3];
            }
        }

        // Get interface states
        $result = Process::run('ip -o link show');
        $lines = explode("\n", trim($result->output()));

        foreach ($lines as $line) {
            if (preg_match('/^\d+:\s+([^:]+):\s+<([^>]+)>/', $line, $matches)) {
                $interface = $matches[1];
                $state = str_contains($matches[2], 'UP') ? 'up' : 'down';

                if (isset($interfaces[$interface])) {
                    $interfaces[$interface]['state'] = $state;
                }
            }
        }

        return array_values($interfaces);
    }

    public function render()
    {
        return view('livewire.status.server');
    }

    public function placeholder()
    {
        return view('components.server-status-placeholder');
    }
}
