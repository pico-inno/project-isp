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
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
            </svg>


        </mijnui:button>

        <!-- User Icon -->
        <mijnui:button
            mijnui-sidebar-parent="user"
            title="User"
            size="icon-sm"
            ghost>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
            </svg>
        </mijnui:button>

        <!-- User Icon -->
        <mijnui:button
            mijnui-sidebar-parent="router"
            title="Router"
            size="icon-sm"
            ghost>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="size-5" id="router">
                <path d="M11.45 5.55c.19.19.5.21.72.04C13.3 4.69 14.65 4.2 16 4.2s2.7.49 3.84 1.39c.21.17.52.15.72-.04l.04-.05c.22-.22.21-.59-.03-.8C19.24 3.57 17.62 3 16 3s-3.24.57-4.57 1.7c-.24.21-.26.57-.03.8l.05.05zm1.7.76c-.25.2-.26.58-.04.8l.04.04c.2.2.5.2.72.04.63-.48 1.38-.69 2.13-.69s1.5.21 2.13.68c.22.17.53.16.72-.04l.04-.04c.23-.23.21-.6-.04-.8-.83-.64-1.84-1-2.85-1s-2.02.36-2.85 1.01zM19 13h-2v-3c0-.55-.45-1-1-1s-1 .45-1 1v3H5c-1.1 0-2 .9-2 2v4c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-4c0-1.1-.9-2-2-2zM8 18H6v-2h2v2zm3.5 0h-2v-2h2v2zm3.5 0h-2v-2h2v2z"></path>
            </svg>
        </mijnui:button>

        <mijnui:button
                        mijnui-sidebar-parent="management"
                        title="Client Account"
                        size="icon-sm"
                        ghost>
            <i class="fa-solid fa-users-gear"></i>
        </mijnui:button>

        <mijnui:button
                        mijnui-sidebar-parent="reports"
                        title="Info"
                        size="icon-sm"
                        ghost>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                <path fill-rule="evenodd" d="M3 2.25a.75.75 0 0 1 .75.75v.54l1.838-.46a9.75 9.75 0 0 1 6.725.738l.108.054A8.25 8.25 0 0 0 18 4.524l3.11-.732a.75.75 0 0 1 .917.81 47.784 47.784 0 0 0 .005 10.337.75.75 0 0 1-.574.812l-3.114.733a9.75 9.75 0 0 1-6.594-.77l-.108-.054a8.25 8.25 0 0 0-5.69-.625l-2.202.55V21a.75.75 0 0 1-1.5 0V3A.75.75 0 0 1 3 2.25Z" clip-rule="evenodd" />
            </svg>

        </mijnui:button>

        <mijnui:button
                        mijnui-sidebar-parent="status"
                        title="Info"
                        size="icon-sm"
                        ghost>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm4.5 7.5a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0v-2.25a.75.75 0 0 1 .75-.75Zm3.75-1.5a.75.75 0 0 0-1.5 0v4.5a.75.75 0 0 0 1.5 0V12Zm2.25-3a.75.75 0 0 1 .75.75v6.75a.75.75 0 0 1-1.5 0V9.75A.75.75 0 0 1 13.5 9Zm3.75-1.5a.75.75 0 0 0-1.5 0v9a.75.75 0 0 0 1.5 0v-9Z" clip-rule="evenodd" />
            </svg>
        </mijnui:button>

        <mijnui:button  wire:navigate  href="{{ route('about') }}"
            mijnui-sidebar-parent=""
            title="Info"
            size="icon-sm"
            ghost>
            <i class="fa-solid fa-circle-info"></i>
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

    @php
     $router = request()->route('router');
     $routerTitle = $router ? $router->name : 'Router Management';
    @endphp
    <mijnui:sidebar.double.content mijnui-sidebar-child="router" title="{{$routerTitle}}">
        <mijnui:list class="flex h-full w-full flex-col items-center gap-2 px-4 py-4">
            @php
                $routerRoutes = [
                    'routers.dashboard',
                    'radius.index', 'radius.create', 'radius.edit',
                    'routers.dhcp-releases',
                ];
            @endphp

            @if(!in_array(request()->route()->getName(), $routerRoutes))
                <mijnui:list.item href="{{ route('routers.index') }}" :active="request()->routeIs('routers.index')" wire:navigate>Routers</mijnui:list.item>
            @else
                <mijnui:list.item href="{{ route('routers.dashboard', ['router' => request()->route('router')]) }}" :active="request()->routeIs('routers.dashboard')" wire:navigate>Dashboard</mijnui:list.item>
                <mijnui:list.item href="{{ route('routers.dhcp-releases', ['router' => request()->route('router')]) }}" :active="request()->routeIs('routers.dhcp-releases')" wire:navigate>DHCP Releases</mijnui:list.item>
                <mijnui:list.item href="{{ route('radius.index', ['router' => request()->route('router')]) }}" :active="request()->routeIs('radius.*')" wire:navigate>Radius</mijnui:list.item>
                <mijnui:list.item href="{{ route('routers.network-logs', ['router' => request()->route('router')]) }}" :active="request()->routeIs('routers.network-logs')" wire:navigate>Network Logs</mijnui:list.item>
                <mijnui:list.item href="{{ route('routers.index') }}" :active="request()->routeIs('routers.index')" wire:navigate>Back Router List</mijnui:list.item>
            @endif

        </mijnui:list>
    </mijnui:sidebar.double.content>

    <mijnui:sidebar.double.content mijnui-sidebar-child="management" title="Management">
        <mijnui:list class="flex h-full w-full flex-col items-center gap-2 px-4 py-4">
            <mijnui:list.item href="{{ route('routers.nas.index') }}" :active="request()->routeIs('routers.nas.index')" wire:navigate>NAS</mijnui:list.item>
            <mijnui:list.item
                href="{{ route('client-users.index') }}"
                :active="request()->routeIs('client-users.*')"
                wire:navigate>
               Client Users
            </mijnui:list.item>

            <mijnui:list.item
                href="{{ route('batch.client-users.index') }}"
                :active="request()->routeIs('batch.client-users.*')"
                wire:navigate>
                Batch Users
            </mijnui:list.item>

            <mijnui:list.item href="{{route('profiles.index')}}" :active="request()->routeIs('profiles.index')" wire:navigate>Profiles</mijnui:list.item>

            <mijnui:list.item
                href="{{ route('attributes.index') }}"
                :active="request()->routeIs('attributes.*')"
                wire:navigate>
                Attribute List
            </mijnui:list.item>


        </mijnui:list>
    </mijnui:sidebar.double.content>


    <mijnui:sidebar.double.content mijnui-sidebar-child="reports" title="Reports">
        <mijnui:list class="flex h-full w-full flex-col items-center gap-2 px-4 py-4">
            <mijnui:list.item href="{{route('reports.radius.log')}}" :active="request()->routeIs('reports.radius.log')" wire:navigate>Radius Connection Attempts</mijnui:list.item>
        </mijnui:list>
    </mijnui:sidebar.double.content>

    <mijnui:sidebar.double.content mijnui-sidebar-child="status" title="Status">
        <mijnui:list class="flex h-full w-full flex-col items-center gap-2 px-4 py-4">
            <mijnui:list.item href="{{route('status.server')}}" :active="request()->routeIs('status.server')" wire:navigate>Server Status</mijnui:list.item>
            <mijnui:list.item href="{{route('status.services')}}" :active="request()->routeIs('status.services')" wire:navigate>Services Status</mijnui:list.item>
        </mijnui:list>
    </mijnui:sidebar.double.content>


</mijnui:sidebar>

<div>
    {{$slot}}
</div>
