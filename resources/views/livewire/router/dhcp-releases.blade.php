<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="{{route('routers.index')}}">Routers</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item wire:navigate href="{{route('routers.dashboard', $router->id)}}">{{ $router->name }}</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>DHCP Releases</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
                DHCP Releases
            </h2>
        </div>
    </div>

    <x-flash-message />
    <!-- Search Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="w-full sm:w-auto sm:flex-1 max-w-xl">
        </div>
        <div class="w-full sm:w-auto">
            <mijnui:button
                size="md"
                wire:click="fetchLeases"
                class="w-full sm:w-auto"
                wire:loading.attr="disabled"
            >
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-rotate" wire:loading.class="animate-spin" wire:loading.attr="disabled"></i>
                    <span wire:loading.remove wire:target="fetchLeases">Refresh</span>
                    <span wire:loading wire:target="fetchLeases">Processing...</span>
                </span>
            </mijnui:button>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-hidden">
        <mijnui:table class="min-w-full divide-y divide-gray-200">
            <mijnui:table.columns class="bg-gray-50">
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">*
                </mijnui:table.column>
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40 truncate">
                    Address
                </mijnui:table.column>
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-44 truncate">
                    MAC Address
                </mijnui:table.column>
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-36 truncate">
                    Server
                </mijnui:table.column>
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-44 truncate">
                    Active Address
                </mijnui:table.column>
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-44 truncate">
                    Active MAC Address
                </mijnui:table.column>
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-60 truncate">
                    Active Host Name
                </mijnui:table.column>
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-28 truncate">
                    Status
                </mijnui:table.column>
            </mijnui:table.columns>


            <mijnui:table.rows class="bg-white divide-y divide-gray-200">
                @forelse($leases as $lease)
                    <mijnui:table.row wire:key="{{ $lease['.id'] }}">
                        <mijnui:table.cell class="px-6 py-4 text-sm text-gray-900">
                            {{ $lease['disabled'] === 'true' ? 'D' : 'E' }}
                        </mijnui:table.cell>
                        <mijnui:table.cell>{{ $lease['address'] ?? '-' }}</mijnui:table.cell>
                        <mijnui:table.cell>{{ $lease['mac-address'] ?? '-' }}</mijnui:table.cell>
                        <mijnui:table.cell>{{ $lease['server'] ?? '-' }}</mijnui:table.cell>
                        <mijnui:table.cell>{{ $lease['active-address'] ?? '-' }}</mijnui:table.cell>
                        <mijnui:table.cell>{{ $lease['active-mac-address'] ?? '-' }}</mijnui:table.cell>
                        <mijnui:table.cell>{{ $lease['host-name'] ?? '-' }}</mijnui:table.cell>
                        <mijnui:table.cell>
                            {{ $lease['status'] ?? ($lease['active-address'] ?? false ? 'Active' : 'Inactive') }}
                        </mijnui:table.cell>
                    </mijnui:table.row>
                @empty
                    <mijnui:table.row>
                        <mijnui:table.cell colspan="8" class="text-center text-sm text-gray-400 py-6">
                            No DHCP leases found.
                        </mijnui:table.cell>
                    </mijnui:table.row>
                @endforelse

            </mijnui:table.rows>
        </mijnui:table>
    </div>

</div>
