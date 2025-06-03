<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="{{ route('users.index') }}">Users</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>{{ $isEdit ? 'Edit' : 'Create' }}</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
                {{ $isEdit ? 'Edit User' : 'Create New User' }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ $isEdit ? 'Update user information' : 'Add a new user to the system' }}
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
                Back to Users
            </mijnui:button>
        </div>
    </div>

    <!-- Form Section -->
    <mijnui:card>
        <mijnui:card.header>
            <h3 class="text-lg font-medium text-gray-900">
                User Information
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Fill in the details below to {{ $isEdit ? 'update' : 'create' }} a user
            </p>
        </mijnui:card.header>

        <mijnui:card.content>
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Name Field -->
                    <mijnui:input
                        required
                        wire:model="name"
                        icon="fa-solid fa-user"
                        placeholder="e.g. John Doe"
                        label="Full Name"
                        :error="$errors->first('name')"
                    />

                    <!-- Role Field -->
                    <mijnui:select
                        wire:model="role_id"
                        label="Role"
                        required
                        :error="$errors->first('role_id')"
                    >
                        @foreach ($roles as $role)
                            <mijnui:select.option value="{{ $role->id }}">
                                {{ $role->name }}
                            </mijnui:select.option>
                        @endforeach
                    </mijnui:select>

                    <!-- Email Field (full width) -->
                    <div class="md:col-span-2">
                        <mijnui:input
                            required
                            type="email"
                            wire:model="email"
                            placeholder="user@example.com"
                            label="Email Address"
                            icon="fa-solid fa-envelope"
                            :error="$errors->first('email')"
                        />
                    </div>

                    <!-- Password Field -->
                    <mijnui:input
                        type="password"
                        viewable
                        wire:model="password"
                        :required="!$isEdit"
                        placeholder="********"
                        label="{{ $isEdit ? 'New Password (leave blank to keep current)' : 'Password' }}"
                        icon="fa-solid fa-lock"
                        :error="$errors->first('password')"
                    />

                    <!-- Password Confirmation -->
                    <mijnui:input
                        type="password"
                        viewable
                        wire:model="password_confirmation"
                        :required="!$isEdit"
                        placeholder="********"
                        label="Confirm Password"
                        icon="fa-solid fa-lock"
                    />
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <mijnui:button
                        type="button"
                        wire:navigate href="{{ route('users.index') }}"
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
                        {{ $isEdit ? 'Update User' : 'Create User' }}
                    </mijnui:button>
                </div>
            </form>
        </mijnui:card.content>
    </mijnui:card>
</div>
