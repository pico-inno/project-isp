<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-150">

        <mijnui:card class="max-w-md p-8 shadow-md">
            <mijnui:card.header>
                <mijnui:card.title>
                    {{ __('Login to your account') }}
                </mijnui:card.title>
                <mijnui:card.description>Enter your email and password below to
                    <strong>Dashboard</strong>
                </mijnui:card.description>
            </mijnui:card.header>
            @if (session('status'))
                <mijnui:alert color="error" class="mb-4">
                    <mijnui:alert.description class="pl-0">{{ session('status') }}</mijnui:alert.description>
                </mijnui:alert>
            @endif
            <mijnui:card.content>
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                    <div>
                        <mijnui:input type="email" id="email" label="Email" wire:model="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div>
                        <mijnui:input type="password" id="password" label="Password" wire:model="password"  name="password"
                                      required autocomplete="current-password"/>
                    </div>


                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <mijnui:checkbox wire:model="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember" />
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <mijnui:button  type="submit" color="primary" class="w-full">
                        {{ __('Log in') }}
                    </mijnui:button>
                </form>
            </mijnui:card.content>
        </mijnui:card>

    </div>
</x-guest-layout>
