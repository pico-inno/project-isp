<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="{{ route('users.index') }}">Routers</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>{{ $isEdit ? 'Edit' : 'Create' }}</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
                {{ $isEdit ? 'Edit Router' : 'Add New Router' }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ $isEdit ? 'Update router information' : 'Add a new router to the system' }}
            </p>
        </div>

        <div class="flex gap-2">
            <mijnui:button
                wire:navigate href="{{ route('users.index') }}"
                class="flex items-center gap-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Routers
            </mijnui:button>
        </div>
    </div>
    <x-flash-message />
    <!-- Form Section -->
    <mijnui:card>
        <mijnui:card.header>
            <h3 class="text-lg font-medium text-gray-900">
                Router Information
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Fill in the details below to {{ $isEdit ? 'update' : 'create' }} a router
            </p>
        </mijnui:card.header>

        <mijnui:card.content>
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <mijnui:input
                        required
                        wire:model="name"
                        icon="fa-regular fa-hard-drive"
                            placeholder="e.g. Mikrotik 0001"
                        label="Router Name"
                        :error="$errors->first('name')"
                    />


                    <mijnui:input
                        required
                        wire:model="host"
                        icon="fa-solid fa-arrow-up-1-9"
                        placeholder="192.168.88.1"
                        label="Router Host"
                        :error="$errors->first('host')"
                    />

                    <mijnui:input
                        required
                        wire:model="port"
                        icon="fa-solid fa-ethernet"
                        placeholder="8728"
                        label="Router Port"
                        :error="$errors->first('port')"
                    />
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <mijnui:input
                        required
                        wire:model="username"
                        icon="fa-solid fa-user"
                        placeholder=""
                        label="Username"
                        :error="$errors->first('username')"
                    />

                    <mijnui:input
                        required
                        wire:model="password"
                        icon="fa-solid fa-lock"
                        placeholder=""
                        label="Password"
                        :error="$errors->first('password')"
                    />
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <mijnui:button
                        type="button"
                        wire:navigate href="{{ route('routers.index') }}"
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
                        {{ $isEdit ? 'Update Router' : 'Add Router' }}
                    </mijnui:button>
                </div>
            </form>
        </mijnui:card.content>
    </mijnui:card>
</div>
