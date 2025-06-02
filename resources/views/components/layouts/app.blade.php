<x-layouts.app.header>
    <x-layouts.app.sidebar>
        <mijnui:main variant="double">
            <div class="pr-4 py-4">
                {{ $slot }}
            </div>
        </mijnui:main>
    </x-layouts.app.sidebar>
</x-layouts.app.header>
@mijnuiScripts
@livewireScripts
