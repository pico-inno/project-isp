<?php

namespace App\Livewire\Radius;

use App\Models\Router;
use App\Traits\HandlesFlashMessages;
use Livewire\Component;
use RouterOS\Client;
use RouterOS\Query;

class Form extends Component
{
    use HandlesFlashMessages;

    public $isEdit = false;
    public $radiusId;
    public $routerId;

    // Form fields
    public $address;
    public $services = [];
    public $secret;
    public $authenticationPort = '1812';
    public $accountingPort = '1813';
    public $timeout = '300ms';
    public $accountingBackup = false;
    public $realm;
    public $protocol = 'udp';
    public $certificate = 'none';
    public $disabled = false;
    public $calledId;
    public $domain;
    public $router;
    public $serviceOptions = [
        'hotspot' => 'Hotspot',
        'ppp' => 'PPP',
    ];

    public function mount(Router $router, $id = null)
    {
        $this->router = $router;
        $this->routerId =    $this->router->id;

        if ($id) {
            $this->isEdit = true;
            $this->radiusId = $id;
            $this->loadRadiusData();
        }
    }

    protected function loadRadiusData()
    {
        try {
            $router = Router::findOrFail($this->routerId);

            $client = new Client([
                'host' => $router->host,
                'user' => $router->username,
                'pass' => $router->password,
                'port' => $router->port ?? 8728,
            ]);

            $query = (new Query('/radius/print'))
                ->where('.id', $this->radiusId);

            $radius = $client->query($query)->read()[0] ?? null;

            if ($radius) {
                $this->address = $radius['address'];
                $this->services = explode(',', $radius['service'] ?? 'hotspot');
                $this->secret = $radius['secret'] ?? '';
                $this->authenticationPort = $radius['authentication-port'] ?? '1812';
                $this->accountingPort = $radius['accounting-port'] ?? '1813';
                $this->timeout = $radius['timeout'] ?? '300ms';
                $this->accountingBackup = $radius['accounting-backup'] === 'true';
                $this->realm = $radius['realm'] ?? null;
                $this->protocol = $radius['protocol'] ?? 'udp';
                $this->certificate = $radius['certificate'] ?? 'none';
                $this->disabled = $radius['disabled'] === 'true';
                $this->calledId = $radius['called-id'] ?? null;
                $this->domain = $radius['domain'] ?? null;
            }

        } catch (\Exception $e) {
            $this->flashError('Failed to load RADIUS data: ' . $e->getMessage());
        }
    }

    public function save()
    {
        $this->validate([
            'address' => 'required|ip',
            'services' => 'required|array|min:1',
            'secret' => 'required|string',
            'authenticationPort' => 'required|numeric',
            'accountingPort' => 'required|numeric',
            'timeout' => 'required|string',
        ]);

        try {
            $router = Router::findOrFail($this->routerId);

            $client = new Client([
                'host' => $router->host,
                'user' => $router->username,
                'pass' => $router->password,
                'port' => $router->port ?? 8728,
            ]);

            $data = [
                'address' => $this->address,
                'service' => implode(',', $this->services),
                'secret' => $this->secret,
                'authentication-port' => $this->authenticationPort,
                'accounting-port' => $this->accountingPort,
                'timeout' => $this->timeout,
                'accounting-backup' => $this->accountingBackup ? 'yes' : 'no',
                'protocol' => $this->protocol,
                'certificate' => $this->certificate,
                'disabled' => $this->disabled ? 'yes' : 'no',
            ];

            if ($this->realm) $data['realm'] = $this->realm;
            if ($this->calledId) $data['called-id'] = $this->calledId;
            if ($this->domain) $data['domain'] = $this->domain;

            if ($this->isEdit) {
                $query = (new Query('/radius/set'))
                    ->equal('.id', $this->radiusId)
                    ->equal('address', $this->address)
                    ->equal('service',  implode(',', $this->services))
                    ->equal('secret', $this->secret)
                    ->equal('authentication-port', $this->authenticationPort)
                    ->equal('accounting-port', $this->accountingPort)
                    ->equal('timeout', $this->timeout)
                    ->equal('accounting-backup', $this->accountingBackup ? 'yes' : 'no')
                    ->equal('protocol', $this->protocol)
                    ->equal('certificate', $this->certificate)
                    ->equal('disabled', $this->disabled ? 'yes' : 'no');

                if ($this->realm) $query->equal('realm', $this->realm);
                if ($this->calledId) $query->equal('called-id', $this->calledId);
                if ($this->domain) $query->equal('domain', $this->domain);

                $client->query($query)->read();
                $this->flashSuccess('RADIUS server updated successfully.');
            } else {
                $query = new Query('/radius/add');
                foreach ($data as $key => $value) {
                    $query->equal($key, $value);
                }
                $client->query($query)->read();
                $this->flashSuccess('RADIUS server added successfully.');
            }

            return redirect()->route('radius.index', $this->routerId);

        } catch (\Exception $e) {
            $this->flashError('Failed to save RADIUS server: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.radius.form');
    }

    public function placeholder()
    {
        return view('components.form-placeholder');
    }
}
