<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="{{ route('routers.index') }}">Management</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>Batches</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">Batch Management</h2>
        </div>
    </div>

    <x-flash-message />

    <!-- Search and Create Section -->
    <div class="flex flex-col sm:flex-row justify-between gap-4">
        <div class="w-full sm:w-auto sm:flex-1 max-w-xl">
        <mijnui:input
            wire:model.live.debounce.300ms="search"
            placeholder="Search batches by name..."
            icon="fa-solid fa-magnifying-glass"
            class="w-full sm:max-w-md"
        />
        </div>
        <div class="w-full sm:w-auto">
            <mijnui:button
                color="primary"
                size="md"
                wire:navigate
                href="{{ route('batch.client-users.create') }}"

            >
                   <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                    New Batch
                </span>
            </mijnui:button>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
        <mijnui:table>
            <mijnui:table.columns>
                <mijnui:table.column>Batch Name</mijnui:table.column>
                <mijnui:table.column>Hotspot</mijnui:table.column>
                <mijnui:table.column>Total Users</mijnui:table.column>
                <mijnui:table.column>Created At</mijnui:table.column>
                <mijnui:table.column class="text-right">Actions</mijnui:table.column>
            </mijnui:table.columns>

            <mijnui:table.rows>
                @forelse ($batches as $b)
                    <mijnui:table.row wire:key="batch-{{ $b->id }}">
                        <mijnui:table.cell class="font-medium">{{ $b->batch_name }}</mijnui:table.cell>
                        <mijnui:table.cell>{{ $b->hospot_id ?? 'N/A' }}</mijnui:table.cell>
                        <mijnui:table.cell>{{ $b->radcheck_accounts_count }} accounts</mijnui:table.cell>
                        <mijnui:table.cell>{{ $b->created_at->format('M d, Y') }}</mijnui:table.cell>
                        <mijnui:table.cell class="flex justify-end space-x-2">
                            <mijnui:button
                                size="xs"
                                color="secondary"
                                href="{{ route('batch.client-users.view', $b->id) }}"
                                wire:navigate
                                title="Edit"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </mijnui:button>
                            <mijnui:button
                                size="xs"
                                color="danger"
                                wire:click="deleteAccount({{ $b->id }})"
                                title="Delete"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </mijnui:button>
                        </mijnui:table.cell>
                    </mijnui:table.row>
                @empty
                    <mijnui:table.row>
                        <mijnui:table.cell colspan="5" class="py-8 text-center">
                            <div class="flex flex-col items-center justify-center space-y-2 text-gray-500">
{{--                                <x-icon.empty class="h-12 w-12" />--}}
                                <h3 class="text-lg font-medium">No batches found</h3>
                                <p class="max-w-md">
                                    {{ $search
                                        ? "No batches match your search for \"{$search}\""
                                        : "No batches have been created yet" }}
                                </p>
                            </div>
                        </mijnui:table.cell>
                    </mijnui:table.row>
                @endforelse
            </mijnui:table.rows>
        </mijnui:table>
    </div>

    <!-- Pagination -->
    @if($batches->hasPages())
        <div class="mt-4">
            {{ $batches->links() }}
        </div>
    @endif
</div>
