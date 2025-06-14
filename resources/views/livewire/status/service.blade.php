<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-gray-900">Service Status</h2>
        <div class="flex items-center space-x-3">
            <span class="text-sm text-gray-500">
                Last checked: {{ $lastChecked ?? 'Never' }}
            </span>
            <mijnui:button
                size="md"
                wire:click="checkServices"
                wire:loading.attr="disabled"
                class="w-full sm:w-auto"
            >
                <span wire:loading.remove wire:target="checkServices">
                    <i class="fas fa-sync-alt mr-1"></i> Refresh
                </span>
                <span wire:loading wire:target="checkServices">
                    <i class="fas fa-spinner fa-spin mr-1"></i> Checking...
                </span>
            </mijnui:button>
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

    @if($isLoading && empty($services))
        <div class="flex justify-center items-center py-8">
            <i class="fas fa-spinner fa-spin text-2xl text-blue-500"></i>
            <span class="ml-2">Loading service statuses...</span>
        </div>
    @else
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <ul class="divide-y divide-gray-200">
                @foreach($services as $name => $isActive)
                    <li class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="min-w-0 flex-1 flex items-center">
                                    <div class="flex-shrink-0">
                                        @if($isActive)
                                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                        @else
                                            <i class="fas fa-times-circle text-red-500 text-xl"></i>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 truncate">
                                            {{ $name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            @if($isActive)
                                                <span class="text-green-600">Running</span>
                                            @else
                                                <span class="text-red-600">Not running</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                @if($isActive)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="text-xs text-gray-500 mt-2">
        <i class="fas fa-info-circle mr-1"></i> Status checked using systemctl
    </div>
</div>
