<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold">{{ $router->name }} Dashboard</h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ $router->host }}:{{ $router->port }}
            </p>
        </div>
    </div>

    <!-- Loading State -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        @foreach(range(1, 4) as $i)
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="animate-pulse flex items-center">
                        <div class="flex-shrink-0 bg-gray-300 rounded-md h-12 w-12"></div>
                        <div class="ml-5 w-0 flex-1">
                            <div class="h-4 bg-gray-300 rounded w-3/4"></div>
                            <div class="mt-2 h-6 bg-gray-300 rounded w-1/2"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Interfaces Loading -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <div class="h-6 bg-gray-300 rounded w-1/4"></div>
        </div>
        <div class="bg-white overflow-hidden">
            <ul class="divide-y divide-gray-200">
                @foreach(range(1, 3) as $i)
                    <li class="px-6 py-4">
                        <div class="animate-pulse flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-5 bg-gray-300 rounded-full w-16"></div>
                                <div class="ml-4">
                                    <div class="h-4 bg-gray-300 rounded w-24"></div>
                                    <div class="mt-2 h-3 bg-gray-300 rounded w-32"></div>
                                </div>
                            </div>
                            <div class="h-3 bg-gray-300 rounded w-12"></div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
