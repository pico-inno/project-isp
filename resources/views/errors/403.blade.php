<x-layouts.guest>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 p-4">
        <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md text-center">
            <!-- Icon for visual recognition -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <!-- Error code and message -->
            <h1 class="text-5xl font-bold text-red-600 mb-2">403</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Access Forbidden</h2>
            <p class="text-gray-600 mb-6">You don't have permission to access.</p>

            <!-- Action button -->
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                @php
                    $previous = url()->previous();
                    $current = url()->current();
                @endphp

                <a href="{{ ($previous && $previous !== $current) ? $previous : route('dashboard') }}"
                   class="inline-flex items-center justify-center gap-1 text-sm transition-colors duration-200 ease-in-out active:brightness-90 disabled:pointer-events-none disabled:opacity-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-main bg-primary text-primary-text hover:opacity-hover h-10 px-3.5 rounded-md w-full">
                    Go Back
                </a>
            </div>

            <!-- Additional help -->
            <p class="mt-6 text-sm text-gray-500">
                If you believe this is an error, please <a href="#" class="text-blue-600 hover:text-blue-800">contact support</a>.
            </p>
        </div>
    </div>
</x-layouts.guest>
