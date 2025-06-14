<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="{{route('ppp_profiles.index')}}">Profiles</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>{{ $isEdit ? 'Edit' : 'Create' }} Profile</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
                {{ $isEdit ? 'Edit PPP Profile' : 'Create New PPP Profile' }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ $isEdit ? 'Update existing PPP profile' : 'Create a new PPP profile for user accounts' }}
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
                PPP Profile Information
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Configure the settings for this PPP profile
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
                    />

                    <mijnui:input
                        required
                        wire:model="rate_limit"
                        placeholder="e.g., 30M/15M"
                        label="Rate Limit (Download/Upload)"
                        type="text"
                        @input="wire:updatedRateLimit"
                    />

                    <mijnui:input
                        required
                        wire:model="price"
                        placeholder=""
                        label="Price"
                        type="number"
                    />

                    <mijnui:input
                        required
                        wire:model="validity_days"
                        placeholder="e.g., 30"
                        label="Validity (Days)"
                        type="number"
                        min="1"
                    />
                </div>


                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <mijnui:button
                        type="button"
                        wire:navigate href="{{ route('ppp_profiles.index') }}"
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
