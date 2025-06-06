<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
{{--                <mijnui:breadcrumbs.item wire:navigate href="{{ route('radius.index') }}">Radius</mijnui:breadcrumbs.item>--}}
                <mijnui:breadcrumbs.item isLast>{{ $isEdit ? 'Edit' : 'Create' }}</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
                {{ $isEdit ? 'Edit Radius Server' : 'Add New Radius Server' }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ $isEdit ? 'Update radius server information' : 'Add a new radius server to the router' }}
            </p>
        </div>

        <div class="flex gap-2">
            <mijnui:button
{{--                wire:navigate href="{{ route('radius.index') }}"--}}
                class="flex items-center gap-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Radius
            </mijnui:button>
        </div>
    </div>
    <x-flash-message />

    <!-- Form Section -->
    <mijnui:card>
        <mijnui:card.header>
            <h3 class="text-lg font-medium text-gray-900">
                Radius Server Information
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Fill in the details below to {{ $isEdit ? 'update' : 'create' }} a radius server
            </p>
        </mijnui:card.header>

        <mijnui:card.content>
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Server Address -->
                    <mijnui:input
                        required
                        wire:model="address"
                        placeholder="192.168.1.1"
                        label="Server Address"
                        type="text"
                    />

                    <!-- Service Type -->
                    <!-- Service Type -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Service Type *</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach($serviceOptions as $value => $label)
                                <div class="flex items-center">
                                    <mijnui:checkbox
                                        wire:model="services"
                                        value="{{ $value }}"
                                        id="service_{{ $value }}"
                                        label="{{ $label }}"
                                    />
                                </div>
                            @endforeach
                        </div>
                        @error('services')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Shared Secret -->
                    <mijnui:input
                        required
                        wire:model="secret"
                        placeholder="Shared secret"
                        label="Shared Secret"
                        type="password"
                    />

                    <!-- Authentication Port -->
                    <mijnui:input
                        required
                        wire:model="authenticationPort"
                        placeholder="1812"
                        label="Authentication Port"
                        type="number"
                    />

                    <!-- Accounting Port -->
                    <mijnui:input
                        required
                        wire:model="accountingPort"
                        placeholder="1813"
                        label="Accounting Port"
                        type="number"
                    />

                    <!-- Timeout -->
                    <mijnui:input
                        required
                        wire:model="timeout"
                        placeholder="300ms"
                        label="Timeout"
                    />

                    <!-- Protocol -->
                    <mijnui:select
                        wire:model="protocol"
                        label="Protocol"
                        required
                    >
                        <mijnui:select.option value="udp">UDP</mijnui:select.option>
                        <mijnui:select.option value="tcp">TCP</mijnui:select.option>
                    </mijnui:select>

                    <!-- Accounting Backup -->
                    <mijnui:checkbox
                        wire:model="accountingBackup"
                        label="Accounting Backup"
                    />

                    <!-- Disabled -->
                    <mijnui:checkbox
                        wire:model="disabled"
                        label="Disabled"
                    />

                    <!-- Realm -->
                    <mijnui:input
                        wire:model="realm"
                        placeholder="Realm"
                        label="Realm"
                    />

                    <!-- Called ID -->
                    <mijnui:input
                        wire:model="calledId"
                        placeholder="Called ID"
                        label="Called ID"
                    />

                    <!-- Domain -->
                    <mijnui:input
                        wire:model="domain"
                        placeholder="Domain"
                        label="Domain"
                    />

                    <!-- Certificate -->
                    <mijnui:input
                        wire:model="certificate"
                        placeholder="none"
                        label="Certificate"
                    />
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <mijnui:button
                        type="button"
{{--                        wire:navigate href="{{ route('radius.index') }}"--}}
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
                        {{ $isEdit ? 'Update Radius Server' : 'Add Radius Server' }}
                    </mijnui:button>
                </div>
            </form>
        </mijnui:card.content>
    </mijnui:card>
</div>
