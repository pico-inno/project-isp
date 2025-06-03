<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="{{ route('users.index') }}">Users</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>List</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
               User List
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
                wire:click="createUser"
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
                <mijnui:table.column class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/5">Name</mijnui:table.column>
                <mijnui:table.column class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">Email</mijnui:table.column>
                <mijnui:table.column class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Role</mijnui:table.column>
                <mijnui:table.column class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Joined</mijnui:table.column>
                <mijnui:table.column class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-1/5">Actions</mijnui:table.column>
            </mijnui:table.columns>

            <mijnui:table.rows class="bg-white divide-y divide-gray-200">
                @forelse ($users as $user)
                    <mijnui:table.row wire:key="user-{{ $user->id }}" >
                        <mijnui:table.cell class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <mijnui:avatar fallback="{{ substr($user->name, 0, 1) }}" class="me-2"></mijnui:avatar>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    @if($user->id === auth()->id())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">You</span>
                                    @endif
                                </div>
                            </div>
                        </mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->email }}
                        </mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 whitespace-nowrap">
                            <mijnui:badge
                                size="sm"
                                color="{{ $user->role ? 'primary' : 'gray' }}"
                                rounded="full"
                            >
                                {{ $user->role->name ?? 'No Role' }}
                            </mijnui:badge>
                        </mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex flex-col">
                                <span>{{ $user->created_at->format('d M Y') }}</span>
                                <span class="text-xs text-gray-400">{{ $user->created_at->format('H:i') }}</span>
                            </div>
                        </mijnui:table.cell>
                        <mijnui:table.cell class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <mijnui:button
                                    size="xs"
                                    color="secondary"
                                    wire:click="editUser({{ $user->id }})"
                                    title="Edit"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </mijnui:button>
                                <mijnui:button
                                    size="xs"
                                    color="danger"
                                    wire:click="deleteUser({{ $user->id }})"
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
    @if($users->hasPages())
{{--      Comming Soon--}}
    @endif
</div>
