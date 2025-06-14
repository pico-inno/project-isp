<div>
    <!-- Connection Status Banner -->
    @if($connectionError)
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-red-400 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-red-700">
                        {{ $connectionError }}
                    </p>
                </div>
                <button wire:click="retryConnection" class="text-sm font-medium text-red-700 hover:text-red-600">
                    Retry
                </button>
            </div>
        </div>
    @endif

    <!-- Loading Indicator -->
    @if($isLoading)
        <div class="flex justify-center items-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
        </div>
    @elseif($isConnected)
        <!-- Dashboard Content -->

        <div class="space-y-6"  wire:poll="connectAndLoadData">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-semibold">{{ $router->name }} Dashboard</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $router->host }}:{{ $router->port }} • {{ $systemInfo['version'] ?? 'Unknown version' }}
                    </p>
                </div>
                <div class="flex gap-2">
                    <mijnui:button
                        wire:navigate href="{{ route('routers.index') }}"
                        class="flex items-center gap-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Back to Routers
                    </mijnui:button>
                </div>
            </div>

            <!-- System Overview Cards -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                <!-- CPU Usage -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">CPU Load</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ $systemInfo['cpu-load'] ?? 'N/A' }}%
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Memory Usage -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h6v6H9z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">Memory Usage</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ $this->formatBytes($systemInfo['free-memory'] ?? 0) }} / {{ $this->formatBytes($systemInfo['total-memory'] ?? 0) }}
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Uptime -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">Uptime</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-lg font-semibold text-gray-900">
                                        {{ $systemInfo['uptime'] }}
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Board Info -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">Board</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-lg font-semibold text-gray-900">
                                        {{ $systemInfo['board-name'] ?? 'N/A' }}
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-2">
            <div
                x-data="{
                        currentTx: {{ last($this->trafficData)['tx'] ?? 0 }},
                        currentRx: {{ last($this->trafficData)['rx'] ?? 0 }}
                    }"
                class="bg-white p-6 rounded-xl shadow-md">
                <input type="hidden" id="traffic_data" value='@json($this->trafficData)' />

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Interface {{ $targetInterface ?? 'N/A' }} Traffic</h3>

                    <div class="flex items-center gap-6 text-sm font-medium">
                        <div class="text-blue-600 flex items-center gap-1">
                          Tx  ▲ <span x-text="currentTx.toFixed(2)"></span>
                        </div>
                        <div class="text-green-600 flex items-center gap-1">
                          Rx  ▼ <span x-text="currentRx.toFixed(2)"></span>
                        </div>
                    </div>
                </div>

                <div>
                    <canvas id="networkTrafficChart"></canvas>
                </div>
                     </div>
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-semibold mb-4">Recent Active PPPoE Connections</h3>
                    <div class="space-y-3">

                        @forelse($activePppoe as $connection)
                            <div class="border-b pb-2 last:border-b-0">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">{{ $connection['name'] ?? 'Unknown' }}</span>
                                    <span class="text-sm text-gray-500">{{ $connection['uptime'] ?? 'N/A' }}</span>
                                </div>
                                <div class="text-sm text-gray-600 mt-1">
                                    <span>IP: {{ $connection['address'] ?? 'N/A' }}</span>
                                    <span class="mx-2">•</span>
                                    <span>Caller ID: {{ $connection['caller-id'] ?? 'N/A' }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center">No active PPPoE connections found</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Interfaces Section -->
            <!-- Updated Interfaces Section in livewire.router.dashboard.blade.php -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Network Interfaces</h3>
                    <p class="mt-1 text-sm text-gray-500">Detailed view of all network interfaces</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Interface</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">MAC Address</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Traffic</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Packets</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Errors/Drops</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($interfaces as $interface)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            @if(str_starts_with($interface['type'] ?? '', 'wireless'))
                                                <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                                                </svg>
                                            @else
                                                <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $interface['name'] }}</div>
                                            <div class="text-sm text-gray-500">{{ $interface['type'] ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $interface['running'] === 'true' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $interface['running'] === 'true' ? 'Active' : 'Inactive' }}
                        </span>
                                    @if($interface['disabled'] === 'true')
                                        <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Disabled
                            </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $interface['mac-address'] ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $this->formatBytes($interface['rx-byte'] ?? 0) }} RX</div>
                                    <div class="text-sm text-gray-500">{{ $this->formatBytes($interface['tx-byte'] ?? 0) }} TX</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($interface['rx-packet'] ?? 0) }} RX</div>
                                    <div class="text-sm text-gray-500">{{ number_format($interface['tx-packet'] ?? 0) }} TX</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>Errors: {{ number_format($interface['rx-error'] ?? 0) }}/{{ number_format($interface['tx-error'] ?? 0) }}</div>
                                    <div>Drops: {{ number_format($interface['rx-drop'] ?? 0) }}/{{ number_format($interface['tx-drop'] ?? 0) }}</div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@script
<script>
    let networkChart = null;
    function timeAgo(secondsAgo) {
        const minutes = Math.floor(secondsAgo / 60);
        return `${minutes} min ago`;
    }

    function renderNetworkChart() {
        const ctx = document.getElementById('networkTrafficChart')?.getContext('2d');
        if (!ctx) return;

        const trafficDataRaw = document.getElementById('traffic_data')?.value;
        let trafficData = JSON.parse(trafficDataRaw || '[]');

        trafficData = trafficData.slice(-10);

        const labels = trafficData.map(item => item.time);
        const rxData = trafficData.map(item => item.rx);
        const txData = trafficData.map(item => item.tx);

        // Destroy previous chart instance
        if (networkChart) {
            networkChart.destroy();
        }

        const config = {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Tx', // Transmit
                        data: txData,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Blue
                        borderColor: 'rgba(54, 162, 235, 1)',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Rx', // Receive
                        data: rxData,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)', // Red/Pink (adjust to purple if needed)
                        borderColor: 'rgba(255, 99, 132, 1)',
                        fill: true,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                animation: false,
                plugins: {
                    title: {
                        display: false,
                    }
                },
                scales: {
                    y: {

                        title: {
                            display: true,
                            text: 'Speed'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Time'
                        }
                    }
                }
            }
        };

        networkChart = new Chart(ctx, config);
    }

    document.addEventListener('DOMContentLoaded', renderNetworkChart);

    Livewire.hook('morphed', () => {
        renderNetworkChart();
    });

    renderNetworkChart();
</script>
@endscript
