<?php

namespace App\Livewire\Status;

use Livewire\Component;
use Illuminate\Support\Facades\Process;

class Service extends Component
{
    public $services = [];
    public $lastChecked;
    public $isLoading = true;
    public $error = null;

    public function mount()
    {
        $this->checkServices();
    }

    public function checkServices()
    {
        $this->isLoading = true;
        $this->error = null;

        try {
            $this->services = [
                'FreeRADIUS' => $this->checkService('freeradius'),
                'MySQL' => $this->checkService('mysql'),
                'MariaDB' => $this->checkService('mariadb'),
                'SSH' => $this->checkService('sshd'),
                'Apache' => $this->checkService('apache2') ?: $this->checkService('httpd'),
                'Nginx' => $this->checkService('nginx'),
            ];

            $this->lastChecked = now()->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            $this->error = "Failed to check service statuses: " . $e->getMessage();
        }

        $this->isLoading = false;
    }

    private function checkService(string $service): bool
    {
        $result = Process::run("systemctl is-active {$service}");
        return trim($result->output()) === 'active';
    }

    public function render()
    {
        return view('livewire.status.service');
    }

    public function placeholder()
    {
        return view('components.service-status-placeholder');
    }
}
