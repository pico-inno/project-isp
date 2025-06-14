<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="{{route('routers.index')}}">Routers</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>Client Router (NAS)</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
                Client Router (NAS)
            </h2>
        </div>
    </div>

    <x-flash-message />
    <!-- Search Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="w-full sm:w-auto sm:flex-1 max-w-xl">
            <mijnui:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search..."
                icon="fa-solid fa-magnifying-glass"
            />
        </div>
        <div class="w-full sm:w-auto">
            <mijnui:button
                color="primary"
                size="md"
                wire:navigate
                href="{{ route('routers.nas.create') }}"
                class="w-full sm:w-auto"
            >
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Client Router
                </span>
            </mijnui:button>
        </div>
    </div>
    <div class="overflow-hidden">
        <mijnui:table class="min-w-full divide-y divide-gray-200">
            <mijnui:table.columns class="bg-gray-50">
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10 truncate">
                    NAS ID
                </mijnui:table.column>
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider truncate">
                    NAS IP/Host
                </mijnui:table.column>
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider truncate">
                    NAS Shortname
                </mijnui:table.column>
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider truncate">
                    Type
                </mijnui:table.column>
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider truncate">
                    Ports
                </mijnui:table.column>
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider truncate">
                    Secret
                </mijnui:table.column>
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider truncate">
                    Virtual Server
                </mijnui:table.column>
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider truncate">
                    Community
                </mijnui:table.column>
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider truncate">
                    Description
                </mijnui:table.column>
                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider truncate">
                    Actions
                </mijnui:table.column>
            </mijnui:table.columns>

            <mijnui:table.rows class="bg-white divide-y divide-gray-200">
                @forelse($nases as $nas)
                    <mijnui:table.row wire:key="nas-{{ $nas->id }}">
                        <mijnui:table.cell class="px-6 py-4 text-sm text-gray-900">{{ $nas->id }}</mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 text-sm text-gray-900">{{ $nas->nasname }}</mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 text-sm text-gray-900">{{ $nas->shortname }}</mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 text-sm text-gray-900">{{ $nas->type }}</mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 text-sm text-gray-900">{{ $nas->ports }}</mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 text-sm text-gray-900">{{ $nas->secret }}</mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 text-sm text-gray-900">{{ $nas->server }}</mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 text-sm text-gray-900">{{ $nas->community }}</mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 text-sm text-gray-900">{{ $nas->description }}</mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 text-sm text-gray-900">
                            <div class="flex items-center gap-2">
                                <mijnui:button
                                    size="xs"
                                    color="secondary"
                                    wire:navigate
                                    href="{{ route('routers.nas.edit', $nas->id) }}"
                                    title="Edit"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </mijnui:button>
                                <mijnui:button
                                    size="xs"
                                    color="danger"
                                    wire:click="deleteNas({{ $nas->id }})"
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
                    <mijnui:table.row>
                        <mijnui:table.cell colspan="8" class="text-center text-sm text-gray-400 py-6">
                            No Client Router found.
                        </mijnui:table.cell>
                    </mijnui:table.row>
                @endforelse

            </mijnui:table.rows>
        </mijnui:table>
    </div>

    {{-- Pagination Links --}}
    <div class="mt-4">
        {{ $nases->links() }}
    </div>

</div>
