<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="{{ route('batch.client-users.index') }}">Batch</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>Create</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
                Create New Batch
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Add a new batch to the system
            </p>
        </div>

        <div class="flex gap-2">
            <mijnui:button
                wire:navigate href="{{ route('batch.client-users.index') }}"
                class="flex items-center gap-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Batches
            </mijnui:button>
        </div>
    </div>

    <!-- Form Section -->
    <mijnui:card>
        <mijnui:card.header>
            <h3 class="text-lg font-medium text-gray-900">
                Batch Information
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Fill in the details below to create a batch
            </p>
        </mijnui:card.header>

        <mijnui:card.content>
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Batch Name -->
                    <mijnui:input
                        required
                        wire:model="batch_name"
                        placeholder="Enter batch name"
                        label="Batch Name"
                        error="{{ $errors->first('batch_name') }}"
                    />

                    <!-- Hotspot -->
{{--                    <mijnui:select--}}
{{--                        wire:model="hotspot_id"--}}
{{--                        label="Hotspot"--}}
{{--                        required--}}
{{--                    >--}}
{{--                    </mijnui:select>--}}

                    <!-- Batch Description -->
                    <mijnui:textarea
                        wire:model="batch_description"
                        placeholder="Enter batch description"
                        label="Description"
                        error="{{ $errors->first('batch_description') }}"
                        class="md:col-span-2"
                    />


                    <mijnui:select
                        wire:model.live="selectedProfile"
                        label="Profiles"
                        :disabled="$isEdit"
                        disabled
                    >
                        @foreach($availableGroups as $group => $label)
                            <mijnui:select.option  value="{{ $group }}">   {{ $label }}</mijnui:select.option>
                        @endforeach
                    </mijnui:select>

                    <mijnui:input
                        type="number"
                        wire:model="number_of_instances"
                        min="1"
                        placeholder="min 4 max 12"
                        label="Number of instances to create"
                        class="w-24"
                    />

                    <mijnui:select
                        wire:model="account_type"
                        label="Account Type"
                        required
                    >
                        <mijnui:select.option value="random_username_and_passowrd">Random username & Random password</mijnui:select.option>
{{--                        <mijnui:select.option value="incremental_username_and_passowrd">Incremental username & Random password</mijnui:select.option>--}}
                        <mijnui:select.option value="random_voucher_code">Random voucher code(no password)</mijnui:select.option>
                    </mijnui:select>

                    <mijnui:input
                        wire:model="username_prefix"
                        min="1"
                        placeholder="First_Floor_"
                        label="Username Prefix"
                        class="w-24"
                    />

                    <mijnui:select
                        wire:model="password_type"
                        label="Password Type"
                        required
                    >
                        <mijnui:select.option value="Cleartext-Password">Cleartext</mijnui:select.option>
                        <mijnui:select.option value="MD5-Password">MD5-Password</mijnui:select.option>
                        <mijnui:select.option value="SHA1-Password">SHA1</mijnui:select.option>
                        <mijnui:select.option value="Crypt-Password">Crypt</mijnui:select.option>
                        <mijnui:select.option value="NT-Password">NT</mijnui:select.option>
                        <mijnui:select.option value="User-Password">User-Password</mijnui:select.option>
                    </mijnui:select>

                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <mijnui:button
                        type="button"
                        wire:navigate href="{{ route('batch.client-users.index') }}"
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
                        Create Batch
                    </mijnui:button>
                </div>
            </form>
        </mijnui:card.content>
    </mijnui:card>
</div>
