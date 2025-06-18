<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="{{route('profiles.index')}}">Profiles</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>{{ $isEdit ? 'Edit' : 'Create' }} Profile</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
                {{ $isEdit ? 'Edit Profile' : 'Create New Profile' }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ $isEdit ? 'Update existing profile' : 'Create a new profile for user accounts' }}
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
                Profile Information
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Configure the settings for this profile
            </p>
        </mijnui:card.header>

        <mijnui:card.content>
            <form wire:submit.prevent="save" class="space-y-6">

                <mijnui:input
                    required
                    wire:model="name"
                    placeholder="e.g., 30Mbps-Package"
                    label="Profile Name"
                    type="text"
                />

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
                        wire:navigate href="{{ route('profiles.index') }}"
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
