<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="{{route('hotspot_profiles.index')}}">Profiles</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>{{ $isEdit ? 'Edit' : 'Create' }} Profile</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
                {{ $isEdit ? 'Edit Hotspot Profile' : 'Create New Hotspot Profile' }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ $isEdit ? 'Update existing Hotspot profile' : 'Create a new Hotspot profile for user accounts' }}
            </p>
        </div>

        <div class="flex gap-2">
            <mijnui:button
                wire:navigate href="{{ route('hotspot_profiles.index') }}"
                class="flex items-center gap-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Profiles
            </mijnui:button>
        </div>
    </div>
    <x-flash-message />

    <!-- Form Section -->
    <mijnui:card>
        <mijnui:card.header>
            <h3 class="text-lg font-medium text-gray-900">
                Hotspot Profile Information
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Configure the settings for this Hotspot profile
            </p>
        </mijnui:card.header>

        <mijnui:card.content>
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <mijnui:input
                        required
                        wire:model="name"
                        placeholder="e.g., 30Mbps-Package"
                        label="Profile Name"
                        type="text"
                        :error="$errors->first('name')"
                    />

                    <mijnui:input
                        required
                        wire:model="rate_limit"
                        placeholder="e.g., 10M/5M"
                        label="Rate Limit (Download/Upload)"
                        type="text"
                        @input="wire:updatedRateLimit"
                        :error="$errors->first('rate_limit')"
                    />

                    <mijnui:input
                        wire:model="address_pool"
                        placeholder="e.g., hotspot-pool"
                        label="Address Pool"
                        :error="$errors->first('address_pool')"
                    />

                    <mijnui:input
                        wire:model="idle_timeout"
                        placeholder="e.g., 5m"
                        label="Idle Timeout"
                        :error="$errors->first('idle_timeout')"
                    />

                    <mijnui:input
                        wire:model="keepalive_timeout"
                        placeholder="e.g., 2m"
                        label="Keepalive Timeout"
                        :error="$errors->first('keepalive_timeout')"
                    />

                    <mijnui:input
                        wire:model="status_autorefresh"
                        placeholder="e.g., 1m"
                        label="Status Auto-refresh"
                        :error="$errors->first('status_autorefresh')"
                    />

                    <mijnui:input
                        wire:model="shared_users"
                        placeholder="e.g., 1"
                        label="Shared Users"
                        type="number"
                        min="1"
                        :error="$errors->first('shared_users')"
                    />

                    <mijnui:input
                        wire:model="session_timeout"
                        placeholder="e.g., 1h"
                        label="Session Timeout"
                        :error="$errors->first('session_timeout')"
                    />

                    <mijnui:checkbox
                        wire:model="mac_cookie"
                        label="Enable MAC Cookie"
                    />

                    <mijnui:checkbox
                        wire:model="http_cookie"
                        label="Enable HTTP Cookie"
                    />
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <mijnui:button
                        type="button"
                        wire:navigate href="{{ route('hotspot_profiles.index') }}"
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
                        {{ $isEdit ? 'Update Profile' : 'Create Profile' }}
                    </mijnui:button>
                </div>
            </form>
        </mijnui:card.content>
    </mijnui:card>
</div>
