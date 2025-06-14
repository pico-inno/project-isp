<div class="space-y-6" wire:poll="loadData">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-gray-900">Server Status</h2>
        <div class="flex items-center space-x-3">
            <span class="text-sm text-gray-500">
                Last updated: {{ $lastUpdated ?? 'Never' }}
            </span>
        </div>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- General Information Card -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">

                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">

            </div>
        </div>

        <!-- Memory Information Card -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">

                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">

            </div>
        </div>

        <!-- Disk Information Card -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">

                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">

            </div>
        </div>

        <!-- Network Information Card -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">

                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">

            </div>
        </div>
    </div>
</div>
