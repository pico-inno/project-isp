<mijnui:sidebar x-data variant="double">
    <!-- --------------------------- Sidebar Header ---------------------------- -->
    <mijnui:sidebar.double>

        <div class="w-full text-center px-2 my-4">
            <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo" class="mx-auto mb-2" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" />
            <mijnui:avatar style="display: none;"  radius='none' fallback="{{ substr(env('APP_NAME'), 0, 1) }}" class="cursor-pointer rounded-sm"></mijnui:avatar>
        </div>

        <mijnui:button
            mijnui-sidebar-parent="dashboard"
            title="Dashboard"
            size="icon-sm"
            ghost>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>

        </mijnui:button>

        <!-- User Icon -->
        <mijnui:button
            mijnui-sidebar-parent="user"
            title="User"
            size="icon-sm"
            ghost>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        </mijnui:button>

    </mijnui:sidebar.double>

    <mijnui:sidebar.double.content mijnui-sidebar-child="default">
    </mijnui:sidebar.double.content>

    <mijnui:sidebar.double.content mijnui-sidebar-child="dashboard" title="Home">
        <mijnui:list class="flex h-full w-full flex-col items-center gap-2 px-4 py-4">
            <mijnui:list.item
                href="{{ route('dashboard') }}"
                :active="request()->routeIs('dashboard')"
                wire:navigate
            >Dashboard</mijnui:list.item>
        </mijnui:list>
    </mijnui:sidebar.double.content>

    <mijnui:sidebar.double.content mijnui-sidebar-child="user" title="User Management">
        <mijnui:list class="flex h-full w-full flex-col items-center gap-2 px-4 py-4">
            <mijnui:list.item href="{{route('users.index')}}" :active="request()->routeIs('users.index')" wire:navigate>Users</mijnui:list.item>
            <mijnui:list.item href="{{route('role-permissions.index')}}" :active="request()->routeIs('role-permissions.index')" wire:navigate>Roles & Permissions</mijnui:list.item>
        </mijnui:list>
    </mijnui:sidebar.double.content>

</mijnui:sidebar>

<div>
    {{$slot}}
</div>
