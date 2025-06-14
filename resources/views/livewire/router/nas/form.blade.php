<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="{{ route('users.index') }}">Routers</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>{{ $isEdit ? 'Edit' : 'Create' }}</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
                {{ $isEdit ? 'Edit NAS' : 'Add NAS' }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ $isEdit ? 'Update NAS information' : 'Add a new NAS to the system' }}
            </p>
        </div>

        <div class="flex gap-2">
            <mijnui:button
                wire:navigate href="{{ route('routers.nas.index') }}"
                class="flex items-center gap-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to NAS Lists
            </mijnui:button>
        </div>
    </div>
    <x-flash-message />
    <!-- Form Section -->
    <mijnui:card>
        <mijnui:card.header>
            <h3 class="text-lg font-medium text-gray-900">
                NAS Information
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Fill in the details below to {{ $isEdit ? 'update' : 'create' }} a NAS
            </p>
        </mijnui:card.header>

        <mijnui:card.content>
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <mijnui:input
                        wire:model="nasname"
                        placeholder="192.168.1.1"
                        label="NAS IP Address"
                        required
                    />

                    <mijnui:input
                        wire:model="shortname"
                        placeholder="MyRouter"
                        label="Short Name"
                        required
                    />

                    <mijnui:select
                        wire:model="type"
                        label="Type"
                        required
                    >
                        <mijnui:select.option value="other">Other</mijnui:select.option>
                        <mijnui:select.option value="cisco">Cisco</mijnui:select.option>
                        <mijnui:select.option value="mikrotik">Mikrotik</mijnui:select.option>
                        <mijnui:select.option value="tp_link">TP-Link</mijnui:select.option>
                    </mijnui:select>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <mijnui:input
                        wire:model="ports"
                        placeholder="1812"
                        label="Ports"
                        type="number"
                    />

                    <mijnui:input
                        wire:model="secret"
                        placeholder="Shared secret"
                        label="Secret"
                        required
                        type="password"
                    />

                    <mijnui:input
                        wire:model="server"
                        placeholder="SNMP server"
                        label="Server"
                    />
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <mijnui:input
                        wire:model="community"
                        placeholder="public"
                        label="Community"
                    />
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <mijnui:textarea
                        wire:model="description"
                        placeholder="Description of this NAS"
                        label="Description"
                        rows="3"
                    />
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <mijnui:button
                        type="button"
                        wire:navigate href="{{ route('routers.nas.index') }}"
                    >
                        Cancel
                    </mijnui:button>

                    <mijnui:button
                        color="primary"
                        type="submit"
                        class="flex items-center gap-2"
                    >
                        <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ $isEdit ? 'Update NAS' : 'Add NAS' }}
                    </mijnui:button>
                </div>
            </form>
        </mijnui:card.content>
    </mijnui:card>
</div>
