<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="{{route('routers.index')}}">Routers</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item wire:navigate href="{{route('routers.dashboard', $router->id)}}">{{ $router->name }}</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>Account</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
                Account List
            </h2>
        </div>
    </div>

    <x-flash-message />
    <!-- Search Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="w-full sm:w-auto sm:flex-1 max-w-xl">
            <mijnui:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search users by name or email..."
                icon="fa-solid fa-magnifying-glass"
            />
        </div>
        <div class="w-full sm:w-auto">
            <mijnui:button
                color="primary"
                size="md"
                href="{{ route('radcheck.create', $router->id) }}"
                wire:navigate
                class="w-full sm:w-auto"
            >
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    New Account
                </span>
            </mijnui:button>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-hidden">
        <mijnui:table class="min-w-full divide-y divide-gray-200">
            <mijnui:table.columns class="bg-gray-50">
                <mijnui:table.column class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/5">Username</mijnui:table.column>
                <mijnui:table.column class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">Secret</mijnui:table.column>
                <mijnui:table.column class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Profile</mijnui:table.column>
                <mijnui:table.column class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-1/5">Actions</mijnui:table.column>
            </mijnui:table.columns>

            <mijnui:table.rows class="bg-white divide-y divide-gray-200">
                @forelse ($radAcc as $account)
                    <mijnui:table.row wire:key="radacc-{{ $account->id }}" >
                        <mijnui:table.cell class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $account->username }}</div>
                        </mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $account->value }}
                        </mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 whitespace-nowrap">
                            <mijnui:badge
                                size="xs"
                                color="info"
                                outline
                                rounded="full"
                            >
                                {{ $account->pppProfile?->name ?? 'No Profile' }}
                            </mijnui:badge>
                        </mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <mijnui:button
                                    size="xs"
                                    color="secondary"
                                    href="{{ route('radcheck.edit', [$router->id, $account->id]) }}"
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
                                    wire:click="deleteAccount({{ $account->id }})"
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
                        <mijnui:table.cell colspan="5" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900">No users found</h3>
                                <p class="text-sm text-gray-500 max-w-md">
                                    @if($search)
                                        Your search for "{{ $search }}" did not match any users. Try a different search term.
                                    @else
                                        There are currently no users in the system. Click "Add User" to create one.
                                    @endif
                                </p>
                            </div>
                        </mijnui:table.cell>
                    </mijnui:table.row>
                @endforelse
            </mijnui:table.rows>
        </mijnui:table>
    </div>

    <!-- Pagination Section -->
    @if($radAcc->hasPages())
        {{--      Comming Soon--}}
    @endif
</div>
