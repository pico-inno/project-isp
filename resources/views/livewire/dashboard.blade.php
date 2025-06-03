<div class="space-y-4">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Users Card -->
        <mijnui:card class="max-w-80 hover:shadow-lg transition-shadow duration-200">
            <mijnui:card.header>
                <span class="inline-flex h-10 w-10 items-center justify-center gap-1 rounded-full bg-blue-100 p-0 text-sm text-blue-600 sm:h-12 sm:w-12">
                    <i class="fa-solid fa-users"></i>
                </span>
            </mijnui:card.header>
            <mijnui:card.content>
                <p class="text-sm font-medium text-muted-text">Total Users</p>
                <h3 class="text-2xl font-semibold text-gray-900">{{ $totalUsers }}</h3>
                <p class="text-xs font-normal text-muted-text">
                    @if($newUsersThisMonth > 0)
                        <span class="text-green-500">+{{ $newUsersThisMonth }}</span>
                        this month
                    @else
                        <span class="text-gray-500">No new users</span>
                        this month
                    @endif
                </p>
            </mijnui:card.content>
        </mijnui:card>

        <!-- Roles Card -->
        <mijnui:card class="max-w-80 hover:shadow-lg transition-shadow duration-200">
            <mijnui:card.header>
                <span class="inline-flex h-10 w-10 items-center justify-center gap-1 rounded-full bg-purple-100 p-0 text-sm text-purple-600 sm:h-12 sm:w-12">
                    <i class="fa-solid fa-layer-group"></i>
                </span>
            </mijnui:card.header>
            <mijnui:card.content>
                <p class="text-sm font-medium text-muted-text">Total Roles</p>
                <h3 class="text-2xl font-semibold text-gray-900">{{ $totalRoles }}</h3>
                <p class="text-xs font-normal text-muted-text">
                    @if($newRolesThisMonth > 0)
                        <span class="text-green-500">+{{ $newRolesThisMonth }}</span>
                        this month
                    @else
                        <span class="text-gray-500">No new roles</span>
                        this month
                    @endif
                </p>
            </mijnui:card.content>
        </mijnui:card>

        <!-- Add more cards here as needed -->
    </div>
</div>
