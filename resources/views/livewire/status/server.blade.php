<div class="space-y-6" wire:poll="loadData">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-gray-900">Server Status</h2>
        <div class="flex items-center space-x-3">
            <span class="text-sm text-gray-500">
                Last updated: {{ $lastUpdated ?? 'Never' }}
            </span>
{{--            <button--}}
{{--                wire:click="loadData"--}}
{{--                wire:loading.attr="disabled"--}}
{{--                class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"--}}
{{--            >--}}
{{--                <span wire:loading.remove wire:target="loadData">--}}
{{--                    <i class="fas fa-sync-alt mr-1"></i> Refresh--}}
{{--                </span>--}}
{{--                <span wire:loading wire:target="loadData">--}}
{{--                    <i class="fas fa-spinner fa-spin mr-1"></i> Updating...--}}
{{--                </span>--}}
{{--            </button>--}}
        </div>
    </div>

    @if($error)
        <div class="rounded-md bg-red-50 p-4 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle h-5 w-5 text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Error</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <p>{{ $error }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($isLoading && empty($systemInfo))
        <div class="flex justify-center items-center py-8">
            <i class="fas fa-spinner fa-spin text-2xl text-blue-500"></i>
            <span class="ml-2">Loading server information...</span>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- General Information Card -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        <i class="fas fa-server mr-2"></i> General Information
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">System distro</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['distro'] ?? 'Unknown' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Uptime</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['uptime'] ?? 'Unknown' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">System Load</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @isset($systemInfo['load'])
                                    {{ $systemInfo['load']['1min'] }} (1m)
                                    {{ $systemInfo['load']['5min'] }} (5m)
                                    {{ $systemInfo['load']['15min'] }} (15m)
                                @else
                                    Unknown
                                @endisset
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Tasks</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @isset($systemInfo['tasks'])
                                    {{ $systemInfo['tasks']['total'] }} total,
                                    {{ $systemInfo['tasks']['running'] }} running,
                                    {{ $systemInfo['tasks']['sleeping'] }} sleeping
                                @else
                                    Unknown
                                @endisset
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">CPU Usage</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @isset($systemInfo['cpu'])
                                    {{ $systemInfo['cpu']['user'] }}% user,
                                    {{ $systemInfo['cpu']['sys'] }}% sys,
                                    {{ $systemInfo['cpu']['idle'] }}% idle
                                @else
                                    Unknown
                                @endisset
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Hostname</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['hostname'] ?? 'Unknown' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Current Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['date'] ?? 'Unknown' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Memory Information Card -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        <i class="fas fa-memory mr-2"></i> Memory Information
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    @isset($systemInfo['memory'])
                        <div class="mb-4">
                            <div class="flex justify-between text-sm font-medium text-gray-500 mb-1">
                                <span>Memory Usage ({{ $systemInfo['memory']['percent'] }}%)</span>
                                <span>
                                    {{ $systemInfo['memory']['used'] }} GB / {{ $systemInfo['memory']['total'] }} GB
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full"
                                     style="width: {{ $systemInfo['memory']['percent'] }}%"></div>
                            </div>
                        </div>
                        <dl class="grid grid-cols-2 gap-x-4 gap-y-4">
                            <div class="col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Total Memory</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['memory']['total'] }} GB</dd>
                            </div>
                            <div class="col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Used Memory</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['memory']['used'] }} GB</dd>
                            </div>
                            <div class="col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Free Memory</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['memory']['free'] }} GB</dd>
                            </div>
                            <div class="col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Available Memory</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['memory']['available'] }} GB</dd>
                            </div>
                        </dl>
                    @else
                        <p class="text-sm text-gray-500">Memory information not available</p>
                    @endisset
                </div>
            </div>

            <!-- Disk Information Card -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        <i class="fas fa-hard-drive mr-2"></i> Disk Information
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    @isset($systemInfo['disk'])
                        <div class="mb-4">
                            <div class="flex justify-between text-sm font-medium text-gray-500 mb-1">
                                <span>Disk Usage ({{ $systemInfo['disk']['percent'] }}%)</span>
                                <span>
                                    {{ $systemInfo['disk']['used'] }} GB / {{ $systemInfo['disk']['total'] }} GB
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-600 h-2.5 rounded-full"
                                     style="width: {{ $systemInfo['disk']['percent'] }}%"></div>
                            </div>
                        </div>
                        <dl class="grid grid-cols-2 gap-x-4 gap-y-4">
                            <div class="col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Total Space</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['disk']['total'] }} GB</dd>
                            </div>
                            <div class="col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Used Space</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['disk']['used'] }} GB</dd>
                            </div>
                            <div class="col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Free Space</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['disk']['free'] }} GB</dd>
                            </div>
                        </dl>
                    @else
                        <p class="text-sm text-gray-500">Disk information not available</p>
                    @endisset
                </div>
            </div>

            <!-- Network Information Card -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        <i class="fas fa-network-wired mr-2"></i> Network Information
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    @isset($systemInfo['network'])
                        @foreach($systemInfo['network'] as $interface)
                            <div class="mb-6 last:mb-0">
                                <h4 class="text-md font-medium text-gray-900 mb-2">
                                    Interface: {{ $interface['name'] }}
                                    <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                              {{ $interface['state'] === 'up' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $interface['state'] }}
                                    </span>
                                </h4>
                                <dl class="grid grid-cols-2 gap-x-4 gap-y-2">
                                    @if($interface['ip'])
                                        <div class="col-span-1">
                                            <dt class="text-sm font-medium text-gray-500">IP Address</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $interface['ip'] }}</dd>
                                        </div>
                                    @endif
                                    @if($interface['mac'])
                                        <div class="col-span-1">
                                            <dt class="text-sm font-medium text-gray-500">MAC Address</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $interface['mac'] }}</dd>
                                        </div>
                                    @endif
                                </dl>
                            </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-500">Network information not available</p>
                    @endisset
                </div>
            </div>
        </div>
    @endif
</div>
