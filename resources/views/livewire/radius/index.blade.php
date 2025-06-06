<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="{{route('routers.index')}}">Routers</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item wire:navigate href="{{route('routers.dashboard', $router->id)}}">{{ $router->name }}</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>Radius</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
                Radius List
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
                wire:click="fetchRadiusData"
                class="w-full sm:w-auto"
                wire:loading.attr="disabled"
            >
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-rotate" wire:loading.class="animate-spin" wire:loading.attr="disabled"></i>
                    <span wire:loading.remove wire:target="fetchRadiusData">Refresh</span>
                    <span wire:loading wire:target="fetchRadiusData">Processing...</span>
                </span>
            </mijnui:button>
            <mijnui:button
                color="primary"
                size="md"
                wire:navigate
                href="{{ route('radius.create', $router->id) }}"
                class="w-full sm:w-auto"
            >
                <span class="flex items-center gap-2">
                  <i class="fa-solid fa-plus"></i>
                    Add New
                </span>
            </mijnui:button>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-hidden">
        <mijnui:table class="min-w-full divide-y divide-gray-200">
            <mijnui:table.columns class="bg-gray-50">
                <mijnui:table.column class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/5">Service</mijnui:table.column>
                <mijnui:table.column class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">Address</mijnui:table.column>
                <mijnui:table.column class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Secret</mijnui:table.column>
                <mijnui:table.column class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Timeout</mijnui:table.column>
                <mijnui:table.column class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Protocol</mijnui:table.column>
                <mijnui:table.column class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Accounting</mijnui:table.column>
                <mijnui:table.column class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-1/5">Actions</mijnui:table.column>
            </mijnui:table.columns>

            <mijnui:table.rows class="bg-white divide-y divide-gray-200">
                @forelse($radiusServers as $radius)
                    <mijnui:table.row wire:key="rad-{{ $radius['.id'] }}" >
                        <mijnui:table.cell class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $radius['service'] ?? '-' }}
                            @if($radius['disabled'] === 'true')
                                <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Disabled
                            </span>
                            @endif
                        </mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $radius['address'] }}
                        </mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ str_repeat('*', strlen($radius['secret'] ?? '')) }}
                        </mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $radius['timeout'] ?? 'default' }}
                        </mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $radius['protocol'] ?? '-' }}
                        </mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ isset($radius['accounting-backup']) ? ($radius['accounting-backup'] === 'true' ? 'Yes' : 'No') : '-' }}
                        </mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <mijnui:button
                                    size="xs"
                                    color="secondary"
                                    href="{{ route('radius.edit', [$router->id, $radius['.id']]) }}"
                                    wire:navigate
                                    title="Edit"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </mijnui:button>
                                <mijnui:button
                                    size="xs"
                                    color="danger"
                                    wire:click="deleteRadiusServer('{{ $radius['.id'] }}')"
                                    title="Delete"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </mijnui:button>
                            </div>
                        </mijnui:table.cell>
                    </mijnui:table.row>
                @empty
                    <!-- ... (empty state remains the same) ... -->
                @endforelse
            </mijnui:table.rows>
        </mijnui:table>
    </div>

    <!-- Pagination Section -->
{{--    @if($radius->hasPages())--}}
        {{--      Comming Soon--}}
{{--    @endif--}}
</div>
