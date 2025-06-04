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

        <!-- User Icon -->
        <mijnui:button
            mijnui-sidebar-parent="router"
            title="Router"
            size="icon-sm"
            ghost>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" id="router">
                <path d="M11.45 5.55c.19.19.5.21.72.04C13.3 4.69 14.65 4.2 16 4.2s2.7.49 3.84 1.39c.21.17.52.15.72-.04l.04-.05c.22-.22.21-.59-.03-.8C19.24 3.57 17.62 3 16 3s-3.24.57-4.57 1.7c-.24.21-.26.57-.03.8l.05.05zm1.7.76c-.25.2-.26.58-.04.8l.04.04c.2.2.5.2.72.04.63-.48 1.38-.69 2.13-.69s1.5.21 2.13.68c.22.17.53.16.72-.04l.04-.04c.23-.23.21-.6-.04-.8-.83-.64-1.84-1-2.85-1s-2.02.36-2.85 1.01zM19 13h-2v-3c0-.55-.45-1-1-1s-1 .45-1 1v3H5c-1.1 0-2 .9-2 2v4c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-4c0-1.1-.9-2-2-2zM8 18H6v-2h2v2zm3.5 0h-2v-2h2v2zm3.5 0h-2v-2h2v2z"></path>
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

    <mijnui:sidebar.double.content mijnui-sidebar-child="router" title="Router Management">
        <mijnui:list class="flex h-full w-full flex-col items-center gap-2 px-4 py-4">
            <mijnui:list.item href="{{route('routers.index')}}" :active="request()->routeIs('routers.index')" wire:navigate>Routers</mijnui:list.item>
        </mijnui:list>
    </mijnui:sidebar.double.content>

</mijnui:sidebar>

<div>
    {{$slot}}
</div>
