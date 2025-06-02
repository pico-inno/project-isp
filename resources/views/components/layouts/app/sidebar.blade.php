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
            <svg
                stroke="currentColor"
                fill="currentColor"
                stroke-width="0"
                viewBox="0 0 24 24"
                height="1em"
                width="1em"
                xmlns="http://www.w3.org/2000/svg">
                <path fill="none" d="M0 0h24v24H0z"></path>
                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"></path>
            </svg>
        </mijnui:button>

        <mijnui:sidebar.double.footer>
            <mijnui:badge color="primary" size="xs" class="mb-1">v1.0.0</mijnui:badge>
        </mijnui:sidebar.double.footer>
    </mijnui:sidebar.double>

    <mijnui:sidebar.double.content mijnui-sidebar-child="dashboard" title="Home">
        <mijnui:list class="flex h-full w-full flex-col items-center gap-2 px-4 py-4">
            <mijnui:list.item
                href="{{ route('dashboard') }}"
                :active="request()->routeIs('dashboard')"
                wire:navigate
            >Dashboard</mijnui:list.item>
        </mijnui:list>
    </mijnui:sidebar.double.content>
</mijnui:sidebar>

<div>
    {{$slot}}
</div>
