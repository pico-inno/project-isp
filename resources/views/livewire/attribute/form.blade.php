<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="{{ route('attributes.index') }}">Attributes</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>{{ $isEdit ? 'Edit' : 'Create' }}</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
                {{ $isEdit ? 'Edit Attribute' : 'Add Attribute' }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ $isEdit ? 'Update attribute information' : 'Add a new attribute to the system' }}
            </p>
        </div>

        <div class="flex gap-2">
            <mijnui:button
                wire:navigate href="{{ route('attributes.index') }}"
                class="flex items-center gap-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Attributes
            </mijnui:button>
        </div>
    </div>
    <x-flash-message />

    <!-- Form Section -->
    <mijnui:card>
        <mijnui:card.header>
            <h3 class="text-lg font-medium text-gray-900">
                Attribute Information
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Fill in the details below to {{ $isEdit ? 'update' : 'create' }} an attribute
            </p>
        </mijnui:card.header>

        <mijnui:card.content>
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <mijnui:input
                        wire:model="vendor"
                        icon="fa-solid fa-building"
                        placeholder="e.g. MikroTik"
                        label="Vendor"
                        help="The vendor this attribute belongs to (if any)"
                    />
                    <mijnui:input
                        required
                        wire:model="attribute_name"
                        icon="fa-solid fa-code"
                        placeholder="e.g. Framed-IP-Address"
                        label="Attribute Name"
                        help="The name of the attribute"
                    />
                    <mijnui:input
                        required
                        wire:model="type"
                        icon="fa-solid fa-tag"
                        placeholder="e.g. ipaddr, integer"
                        label="Type"
                        help="The type of attribute (e.g., integer, ipaddr, etc.)"
                        list="type_list"
                    />
                    <datalist id="type_list"><option value="string">
                        </option><option value="integer">
                        </option><option value="ipaddr">
                        </option><option value="date">
                        </option><option value="octets">
                        </option><option value="ipv6addr">
                        </option><option value="ifid">
                        </option><option value="abinary">
                        </option></datalist>

                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <mijnui:input
                        required
                        wire:model="value"
                        icon="fa-solid fa-font"
                        placeholder="e.g. 192.168.1.1"
                        label="Default Value"
                        help="The default value for this attribute"
                    />
                    <mijnui:input
                        wire:model="format"
                        icon="fa-solid fa-align-left"
                        placeholder="e.g. ipv4"
                        label="Format"
                        help="The expected format of the value"
                    />
                    <mijnui:input
                        wire:model="recommended_op"
                        icon="fa-solid fa-sliders"
                        placeholder="e.g. ==, :=, +="
                        label="Recommended Operator"
                        help="Recommended operator for this attribute"
                        list="RecommendedOP_list"
                    />
                    <datalist id="RecommendedOP_list">
                        <option value=":=">
                        </option><option value="=">
                        </option><option value="+=">
                        </option><option value="==">
                        </option><option value="!=">
                        </option><option value="&gt;">
                        </option><option value="&gt;=">
                        </option><option value="&lt;">
                        </option><option value="&lt;=">
                        </option><option value="=~">
                        </option><option value="!~">
                        </option><option value="=*">
                        </option><option value="!*">
                        </option>
                    </datalist>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <mijnui:input
                        wire:model="recommended_table"
                        icon="fa-solid fa-table"
                        placeholder="e.g. radcheck"
                        label="Recommended Table"
                        help="Recommended database table for this attribute"
                        list="recommended_table_list"
                    />
                    <datalist id="recommended_table_list"><option value="radcheck">
                        </option><option value="radreply">
                        </option></datalist>
                    <mijnui:input
                        wire:model="recommended_helper"
                        icon="fa-solid fa-question-circle"
                        placeholder="e.g. authtype"
                        label="Recommended Helper"
                        help="Helper function/method for this attribute"
                        list="recommended_helper_list"
                    />
                    <datalist id="recommended_helper_list"><option value="date">
                        </option><option value="datetime">
                        </option><option value="authtype">
                        </option><option value="framedprotocol">
                        </option><option value="servicetype">
                        </option><option value="kbitspersecond">
                        </option><option value="bitspersecond">
                        </option><option value="volumebytes">
                        </option><option value="mikrotikRateLimit">
                        </option></datalist>
                    <mijnui:textarea
                        wire:model="recommended_tooltip"
                        label="Recommended Tooltip"
                        placeholder="Additional information about this attribute"
                        help="Help text that will be shown to users"
                        rows="3"
                    />
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <mijnui:button
                        type="button"
                        wire:navigate href="{{ route('attributes.index') }}"
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
                        {{ $isEdit ? 'Update Attribute' : 'Add Attribute' }}
                    </mijnui:button>
                </div>
            </form>
        </mijnui:card.content>
    </mijnui:card>
</div>
