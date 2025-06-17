    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <mijnui:breadcrumbs>
                    <mijnui:breadcrumbs.item wire:navigate href="{{route('client-users.index')}}">Management</mijnui:breadcrumbs.item>
                    <mijnui:breadcrumbs.item >Client Users</mijnui:breadcrumbs.item>
                    <mijnui:breadcrumbs.item isLast>{{ $isEdit ? 'Edit' : 'Create' }}</mijnui:breadcrumbs.item>
                </mijnui:breadcrumbs>
                <h2 class="text-2xl font-semibold mt-2">
                    {{ $isEdit ? 'Edit Client User Account' : 'Add New Client User Account' }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $isEdit ? 'Update Client User account information' : 'Add a new Client User authentication account' }}
                </p>
            </div>

            <div class="flex gap-2">
            </div>
        </div>
        <x-flash-message />

        <!-- Form Section -->
        <mijnui:card class="bg-white">
            <mijnui:card.header>
                <h3 class="text-lg font-medium text-gray-900">
                    Client User Account Information
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Fill in the details below to {{ $isEdit ? 'update' : 'create' }} a Client User account
                </p>
            </mijnui:card.header>

            <mijnui:card.content>
                <div class="grid grid-cols-1 gap-6">
                    <!-- Authentication Type -->
                    <mijnui:select
                        wire:model.live="authenticationType"
                        label="Authentication Type"
                        :disabled="$isEdit"

                    >
                            <mijnui:select.option value="username_password">Username + Password</mijnui:select.option>
                            <mijnui:select.option value="pin">PIN Code</mijnui:select.option>
                            <mijnui:select.option value="mac">MAC Address</mijnui:select.option>
                    </mijnui:select>



                    <!-- Dynamic Field based on Authentication Type -->
                    @if($authenticationType === 'username_password')
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Username Field -->
                            <mijnui:input
                                required
                                wire:model="username"
                                placeholder="Enter username"
                                label="Username"
                                type="text"
                                :disabled="$isEdit"
                            />
                            <!-- Password Field -->
                            <mijnui:input
                                required
                                wire:model="value"
                                viewable
                                :disabled="$isEdit"
                                placeholder="Enter password"
                                label="Password"
                                type="password"
                            />

                            <!-- Password Type -->
                            <mijnui:select
                                wire:model.live="passwordType"
                                label="Password Type"
                                :disabled="$isEdit"
                                disabled
                                 >
                                <mijnui:select.option value="Cleartext-Password">Cleartext</mijnui:select.option>
                                <mijnui:select.option value="MD5-Password">MD5-Password</mijnui:select.option>
                                <mijnui:select.option value="SHA1-Password">SHA1</mijnui:select.option>
                                <mijnui:select.option value="Crypt-Password">Crypt</mijnui:select.option>
                                <mijnui:select.option value="NT-Password">NT</mijnui:select.option>
                                <mijnui:select.option value="User-Password">User-Password</mijnui:select.option>
                            </mijnui:select>
                        </div>
                    @elseif($authenticationType === 'pin')
                        <mijnui:input
                            required
                            wire:model="username"
                            placeholder="Enter PIN code"
                            label="PIN Code"
                            type="text"
                        />
                    @elseif($authenticationType === 'mac')
                        <mijnui:input
                            required
                            wire:model="username"
                            placeholder="Enter MAC address (e.g., 00:11:22:33:44:55)"
                            label="MAC Address"
                            type="text"
                        />
                    @endif

                </div>

                <!-- Additional Attributes Section -->
                <div class="gap-3 mt-5 py-4 border-t border-gray-200">
                    <div class="grid grid-cols-1 gap-6 mb-6">
                        <div class="md:col-span-5">
                            <mijnui:select
                                wire:model.live="searchVendor"
                                label="Vendor Dictionary"
                                 >
                                <mijnui:select.option value="custom_attributes">Custom Attribute</mijnui:select.option>
                                @foreach($vendorOptions as $value => $label)
                                    <mijnui:select.option value="{{ $value }}">{{ $label }}</mijnui:select.option>
                                @endforeach
                            </mijnui:select>
                            <p class="text-xs text-gray-500 mt-1">
                                Select a vendor to see available attributes
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach($attributesData as $index => $attribute)
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-12 items-end" wire:key="attribute-{{ $index }}">
                                <div class="md:col-span-3">
                                    <mijnui:input
                                        class="w-full"
                                        wire:model="attributesData.{{ $index }}.attribute"
                                        placeholder=""
                                        label="Attribute"
                                        list="attribute_list"
                                    />

                                    <datalist id="attribute_list">
                                        @foreach($dictionaryOptions as $dictionary)
                                            <option value="{{ $dictionary['attribute'] }}">{{ $dictionary['attribute'] }}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="md:col-span-3">
                                    <mijnui:input
                                        class="w-full"
                                        wire:model="attributesData.{{ $index }}.value"
                                        placeholder="Enter value"
                                        label="Value"
                                    />
                                </div>
                                <div class="md:col-span-2">
                                    <mijnui:select
                                        wire:model="attributesData.{{ $index }}.op"
                                        label="OP"
                                         >
                                            <mijnui:select.option value=":=">:=</mijnui:select.option>
                                            <mijnui:select.option value="=">=</mijnui:select.option>
                                            <mijnui:select.option value="+=">+=</mijnui:select.option>
                                            <mijnui:select.option value="==">==</mijnui:select.option>
                                            <mijnui:select.option value="!=">!=</mijnui:select.option>
                                            <mijnui:select.option value=">">&gt;</mijnui:select.option>
                                            <mijnui:select.option value=">=">&gt;=</mijnui:select.option>
                                            <mijnui:select.option value="<">&lt;</mijnui:select.option>
                                            <mijnui:select.option value="<=">&lt;=</mijnui:select.option>
                                            <mijnui:select.option value="=~">=~</mijnui:select.option>
                                            <mijnui:select.option value="!~">!~</mijnui:select.option>
                                            <mijnui:select.option value="=*">=*</mijnui:select.option>
                                            <mijnui:select.option value="!*">!*</mijnui:select.option>
                                    </mijnui:select>
                                </div>
                                <div class="md:col-span-2">
                                    <mijnui:select
                                        wire:model="attributesData.{{ $index }}.table"
                                        label="Table"
                                         >
                                        <mijnui:select.option value="check">Check</mijnui:select.option>
                                        <mijnui:select.option value="reply">Reply</mijnui:select.option>
                                    </mijnui:select>
                                </div>
                                <div class="md:col-span-2">
                                    <mijnui:button
                                        type="button"
                                        color="danger"
                                        wire:click="removeAttribute({{ $index }})"
                                        size="sm"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </mijnui:button>
                                </div>
                            </div>
                        @endforeach

                        <div class="pt-2">
                            <mijnui:button
                                type="button"
                                wire:click="addAttribute"
                                color="secondary"
                            >
                                Add Attribute
                            </mijnui:button>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <mijnui:button
                        type="button"
                        wire:navigate href="{{ route('client-users.index') }}"
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
