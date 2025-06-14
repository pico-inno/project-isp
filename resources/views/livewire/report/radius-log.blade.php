<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <mijnui:breadcrumbs>
                <mijnui:breadcrumbs.item wire:navigate href="">Reports</mijnui:breadcrumbs.item>
                <mijnui:breadcrumbs.item isLast>RADIUS Connection Attempts</mijnui:breadcrumbs.item>
            </mijnui:breadcrumbs>
            <h2 class="text-2xl font-semibold mt-2">
                RADIUS Connection Attempts
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Showing {{ $logs->firstItem() }} to {{ $logs->lastItem() }} of {{ $logs->total() }} records
            </p>
        </div>
    </div>

    <x-flash-message />

    <!-- Filters Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="w-full sm:w-auto sm:flex-1 max-w-xl">
            <mijnui:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search username or NAS IP..."
                icon="fa-solid fa-magnifying-glass"
            />
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <mijnui:select
                wire:model.live="statusFilter"
                class="w-32"
            >
                <mijnui:select.option value="completed">Completed</mijnui:select.option>
                <mijnui:select.option value="active">Active</mijnui:select.option>
                <mijnui:select.option value="abnormal_termination">Abnormal Termination</mijnui:select.option>
            </mijnui:select>

            <mijnui:select
                wire:model.live="perPage"
                class="w-32"
            >
                <mijnui:select.option value="10">10 per page</mijnui:select.option>
                <mijnui:select.option value="25">25 per page</mijnui:select.option>
                <mijnui:select.option value="50">50 per page</mijnui:select.option>
                <mijnui:select.option value="100">100 per page</mijnui:select.option>
            </mijnui:select>
        </div>
    </div>

    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
        <mijnui:table class="min-w-full divide-y divide-gray-300">
            <mijnui:table.columns class="bg-gray-50">
                <mijnui:table.column
                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                    wire:click="sortBy('username')"
                >
                    Username
                    @if($sortField === 'username')
                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                    @else
                        <i class="fas fa-sort ml-1 text-gray-300"></i>
                    @endif
                </mijnui:table.column>

                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    NAS IP
                </mijnui:table.column>

                <mijnui:table.column
                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                    wire:click="sortBy('acctstarttime')"
                >
                    Start Time
                    @if($sortField === 'acctstarttime')
                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                    @else
                        <i class="fas fa-sort ml-1 text-gray-300"></i>
                    @endif
                </mijnui:table.column>

                <mijnui:table.column class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                </mijnui:table.column>
            </mijnui:table.columns>

            <mijnui:table.rows class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                    <mijnui:table.row wire:key="log-{{ $log->radacctid }}">
                        <mijnui:table.cell class="px-4 py-4 text-sm text-gray-900">
                            <div class="font-medium">{{ $log->username }}</div>
                            @if($log->calledstationid)
                                <div class="text-xs text-gray-500">MAC: {{ $log->calledstationid }}</div>
                            @endif
                        </mijnui:table.cell>

                        <mijnui:table.cell class="px-4 py-4 text-sm text-gray-900">
                            {{ $log->nasipaddress }}
                            @if($log->nasidentifier)
                                <div class="text-xs text-gray-500">{{ $log->nasidentifier }}</div>
                            @endif
                        </mijnui:table.cell>

                        <mijnui:table.cell class="px-4 py-4 text-sm text-gray-900">
                            {{ $log->acctstarttime->format('Y-m-d H:i:s') }}
                            @if($log->acctsessiontime)
                                <div class="text-xs text-gray-500">
                                    Duration: {{ gmdate('H:i:s', $log->acctsessiontime) }}
                                </div>
                            @endif
                        </mijnui:table.cell>

                        <mijnui:table.cell class="px-4 py-4 text-sm">
                            @if ($log->acctstoptime)
                                @php
                                    $normalTerminationCauses = ['User-Request', 'Session-Timeout', 'Idle-Timeout'];
                                @endphp

                                @if (in_array($log->acctterminatecause, $normalTerminationCauses))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Completed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Terminated ({{ $log->acctterminatecause }})
                                </span>
                                @endif
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-spinner fa-spin mr-1"></i> Active
                                </span>
                            @endif
                        </mijnui:table.cell>
                    </mijnui:table.row>
                @empty
                    <mijnui:table.row>
                        <mijnui:table.cell colspan="4" class="text-center text-sm text-gray-400 py-6">
                            No connection attempts found matching your criteria.
                        </mijnui:table.cell>
                    </mijnui:table.row>
                @endforelse
            </mijnui:table.rows>
        </mijnui:table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>
