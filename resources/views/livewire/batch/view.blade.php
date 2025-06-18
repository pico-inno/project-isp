<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="{{ route('batch.client-users.index') }}">Batch</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>Create</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
                Batch Details
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Created: {{ $batch->created_at->format('Y-m-d H:i:s') }}
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
                {{ $batch->batch_name }}
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Total Accounts: {{ $batch->radcheckAccounts->count() }}
            </p>
        </mijnui:card.header>

        <mijnui:card.content>
            <mijnui:table>
                <mijnui:table.columns>
                    <mijnui:table.column>Username</mijnui:table.column>
                    <mijnui:table.column>Password</mijnui:table.column>
                    <mijnui:table.column>Groups</mijnui:table.column>
                </mijnui:table.columns>

                <mijnui:table.rows>
                    @forelse ($userAccounts as $account)
                        <mijnui:table.row wire:key="account-{{ $account['username'] }}">
                            <mijnui:table.cell class="font-medium">{{ $account['username'] }}</mijnui:table.cell>
                            <mijnui:table.cell>{{ $account['password'] }}</mijnui:table.cell>
                            <mijnui:table.cell>{{ $account['groups'] ?: 'None' }}</mijnui:table.cell>
                        </mijnui:table.row>
                    @empty
                        <mijnui:table.row>
                            <mijnui:table.cell colspan="5" class="py-8 text-center">
                                <div class="flex flex-col items-center justify-center space-y-2 text-gray-500">
                                    {{--                                <x-icon.empty class="h-12 w-12" />--}}
                                    <h3 class="text-lg font-medium">No batches found</h3>
                                    <p class="max-w-md">
                                        {{ $search
                                            ? "No batches match your search for \"{$search}\""
                                            : "No batches have been created yet" }}
                                    </p>
                                </div>
                            </mijnui:table.cell>
                        </mijnui:table.row>
                    @endforelse
                </mijnui:table.rows>
            </mijnui:table>
        </mijnui:card.content>
    </mijnui:card>
</div>
