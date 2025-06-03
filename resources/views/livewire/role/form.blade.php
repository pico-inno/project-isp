
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="{{ route('role-permissions.index') }}">Roles</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>{{ $isEdit ? 'Edit' : 'Create' }}</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
                {{ $isEdit ? 'Edit Role' : 'Create New Role' }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ $isEdit ? 'Update role permissions' : 'Add a new role to the system' }}
            </p>
        </div>

        <div class="flex gap-2">
            <mijnui:button
                wire:navigate href="{{ route('role-permissions.index') }}"
                class="flex items-center gap-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Roles
            </mijnui:button>
        </div>
    </div>

    <x-flash-message />

    <!-- Form Section -->
    <mijnui:card>
        <mijnui:card.header>
            <h3 class="text-lg font-medium text-gray-900">
                Role Permissions
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Select the permissions below to {{ $isEdit ? 'update' : 'create' }} this role.
            </p>
        </mijnui:card.header>

        <mijnui:card.content>
            <form wire:submit.prevent="save">
                <mijnui:card.content>
                    <mijnui:input placeholder="e.g. Assistant" label="Role Name" wire:model="role_name" required />
                    <mijnui:separator />
                    <div class="mt-3">
                        <mijnui:label>Permissions</mijnui:label>
                        <mijnui:error name="selected_permissions" />
                        <div class="w-full overflow-auto mt-2">
                            <table class="w-full table-fixed">
                                @foreach ($fPermissions as $fPermission)
                                    <tr class=" hover:bg-gray-50 transition-colors duration-200">
                                        <!-- Permission Group Name -->
                                        <td class="py-4 font-semibold w-24">
                                            {{ ucwords($fPermission->name) }}
                                        </td>

                                        <!-- Permissions List -->
                                        <td class="p-4">
                                            <div class="flex flex-wrap items-center gap-4">
                                                <mijnui:checkbox.group class="flex gap-8 text-sm">
                                                    @foreach ($fPermission->permissions as $permission)
                                                        <div class="flex-shrink-0">
                                                            <mijnui:checkbox wire:model.live="selected_permissions"
                                                                             id="{{ $fPermission->name }}" value="{{ $permission->id }}"
                                                                             label="{{ $permission->name }}" />
                                                        </div>
                                                    @endforeach
                                                </mijnui:checkbox.group>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                </mijnui:card.content>
                <mijnui:card.footer class="flex justify-end gap-2">
                    <mijnui:button
                        color="secondary"
                        wire:navigate
                        href="{{ route('role-permissions.index') }}"
                    >
                        Cancel
                    </mijnui:button>
                    <mijnui:button
                        color="primary"
                        type="submit"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading wire:target="save">  {{ $isEdit ? 'Updating...' : 'Creating...' }}</span>
                        <span wire:loading.remove wire:target="save">  {{ $isEdit ? 'Update Role' : 'Create Role' }}</span>
                    </mijnui:button>
                </mijnui:card.footer>
            </form>
        </mijnui:card.content>
    </mijnui:card>
</div>
