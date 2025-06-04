<!DOCTYPE html>
<html lang="en" xmlns:mijnui="http://www.w3.org/1999/html">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen " x-data="{ drawerOpen: false }" x-init="$store.theme.init()">
<mijnui:header>
    <mijnui:header.navbar>

        <mijnui:icon x-on:click="$store.theme.switchTheme()"
                     class="hover:bg-accent p-1 size-8 rounded  cursor-pointer border">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="size-6 dark-icon hidden">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
            </svg>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="size-6 light-icon ">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
            </svg>
        </mijnui:icon>

        <mijnui:dropdown>
            <mijnui:dropdown.trigger>
                <mijnui:avatar fallback="P" class="cursor-pointer"></mijnui:avatar>
            </mijnui:dropdown.trigger>
            <mijnui:dropdown.content align="right">
                <mijnui:dropdown.body>
                    <mijnui:list class="min-w-32">
                        <mijnui:list.item href="{{ route('profile.edit') }}">
                            {{ __('Profile') }}
                        </mijnui:list.item>
                        <form method="POST" action="{{ route('logout') }}" class="w-full ">
                            @csrf
                            <mijnui:list.item as="button" type="submit" icon="arrow-right-start-on-rectangle" :href="route('logout')"
                                              onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                              class="w-fit">
                                {{ __('Log Out') }}
                            </mijnui:button>
                        </form>
                    </mijnui:list>
                </mijnui:dropdown.body>
            </mijnui:dropdown.content>
        </mijnui:dropdown>

    </mijnui:header.navbar>
</mijnui:header>

{{ $slot }}

@mijnuiScripts
@stack('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('theme', {
            theme: 'light',
            init() {
                this.theme = localStorage.getItem('theme') || 'light';
                if (this.theme === 'dark') {
                    document.documentElement.classList.add('dark');
                    this.changeThemeIcon();
                }
            },
            switchTheme() {
                document.documentElement.classList.toggle('dark');
                this.changeThemeIcon();
                this.theme = this.theme === 'light' ? 'dark' : 'light';
                localStorage.setItem('theme', this.theme);
            },
            changeThemeIcon() {
                document.querySelector('.dark-icon').classList.toggle('hidden');
                document.querySelector('.light-icon').classList.toggle('hidden');
            }
        })
    });
</script>
@stack('scripts')
</body>

</html>
