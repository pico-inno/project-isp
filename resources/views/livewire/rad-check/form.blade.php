<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="{{route('routers.index')}}">Routers</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>{{ $isEdit ? 'Edit' : 'Create' }}</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
                {{ $isEdit ? 'Edit User Account' : 'Add New User Account' }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ $isEdit ? 'Update user account information' : 'Add a new user account to the router' }}
            </p>
        </div>

        <div class="flex gap-2">
        </div>
    </div>
    <x-flash-message />

    <!-- Form Section -->
    <mijnui:card>
        <mijnui:card.header>
            <h3 class="text-lg font-medium text-gray-900">
                Radius User Account Information
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Fill in the details below to {{ $isEdit ? 'update' : 'create' }} a user account
            </p>
        </mijnui:card.header>

        <mijnui:card.content>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <mijnui:input
                        required
                        wire:model="username"
                        placeholder="Enter username"
                        label="Username"
                        type="text"
                        :disabled="$isEdit"
                    />

                    <mijnui:input
                        required
                        wire:model="value"
                        viewable
                        :disabled="$isEdit"
                        placeholder="Enter password"
                        label="Password"
                        type="password"
                    />
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <mijnui:select
                        wire:model="selectedPackage"
                        label="PPPoE Package"
                        placeholder="Select a package"
                        required
                        :error="$errors->first('selectedPackage')"
                    >
                        @foreach($packages as $package)
                            <mijnui:select.option value="{{ $package->id }}">
                                {{ $package->name }} ( {{$package->rate_limit ? $package->rate_limit : $package->download_speed.'/'.$package->upload_speed}})
                            </mijnui:select.option>
                        @endforeach
                    </mijnui:select>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <mijnui:button
                        type="button"
                        wire:navigate href="{{ route('radcheck.index', ['serviceType' => $serviceType]) }}"
                    >
                        Cancel
                    </mijnui:button>

                    <mijnui:button
                        color="primary"
                        wire:click="save"
                        class="flex items-center gap-2"
                    >
                        <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ $isEdit ? 'Update Account' : 'Create Account' }}
                    </mijnui:button>
                </div>
        </mijnui:card.content>
    </mijnui:card>
</div>
