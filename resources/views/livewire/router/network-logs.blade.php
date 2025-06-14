<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Router Logs - {{ $router->name }}</h2>
        <div class="flex space-x-4 items-center">
            <select
                wire:model="logType"
                class="border rounded px-3 py-1"
                wire:loading.attr="disabled"
            >
                <option value="hotspot">Hotspot Logs</option>
                <option value="pppoe">PPPoE Logs</option>
            </select>

            <select
                wire:model="logCount"
                class="border rounded px-3 py-1"
                wire:loading.attr="disabled"
            >
                <option value="50">Show 50</option>
                <option value="100">Show 100</option>
                <option value="200">Show 200</option>
                <option value="500">Show 500</option>
            </select>

            <button
                wire:click="refreshLogs"
                class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600 flex items-center"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>Refresh</span>
                <span wire:loading>
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </button>
        </div>
    </div>

    @error('connection')
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ $message }}
    </div>
    @enderror

    <div class="mb-4">
        <input
            type="text"
            wire:model.debounce.500ms="search"
            placeholder="Search logs..."
            class="border rounded w-full px-3 py-2"
            wire:loading.attr="disabled"
        >
    </div>

    <div class="bg-gray-50 rounded p-4">
        @if($isLoading)
            <div class="text-center py-4">
                <svg class="animate-spin h-8 w-8 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-2">Loading logs...</p>
            </div>
        @elseif(count($logs) > 0)
            <div class="space-y-2 max-h-96 overflow-y-auto">
                @foreach($logs as $log)
                    <div class="p-2 hover:bg-gray-100 rounded break-all font-mono text-sm">
                        {{ $log }}
                    </div>
                @endforeach
            </div>
            <div class="mt-4 text-sm text-gray-500">
                Showing {{ min($logCount, count($logs)) }} of {{ count($logs) }} logs
            </div>
        @else
            <div class="text-center text-gray-500 py-4">
                No logs found
            </div>
        @endif
    </div>
</div>
