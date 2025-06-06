<div class="min-h-screen bg-gray-50">

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class=" overflow-hidden">
            <!-- About Section Header -->
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold">About PPPoE Manager</h2>
                        <p class="mt-2 opacity-90">Comprehensive ISP Management Solution</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Application Overview -->
            <div class="p-6 border-b">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Application Overview</h3>
                <p class="text-gray-600 mb-4">
                    A web-based management system for Internet Service Providers (ISPs) that use PPPoE for customer authentication and management.
                </p>

                <div class="grid md:grid-cols-2 gap-6 mt-6">
                    <!-- Feature Cards -->
                    <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                        <div class="flex items-center mb-3">
                            <div class="bg-indigo-100 p-2 rounded-full mr-3">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <h4 class="font-medium text-gray-800">Customer Management</h4>
                        </div>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Create/edit/delete customer accounts</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Assign bandwidth profiles</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Manage active sessions</span>
                            </li>
                        </ul>
                    </div>

                    <!-- More feature cards would go here following the same pattern -->
                </div>
            </div>

            <!-- Technical Specifications -->
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Technical Specifications</h3>

                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="font-medium text-gray-700 mb-3">Core Technologies</h4>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm">PHP 8.0+</span>
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm">Laravel</span>
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm">Livewire</span>
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm">MySQL/PostgreSQL</span>
                    </div>
                </div>

                <div class="mt-6">
                    <h4 class="font-medium text-gray-700 mb-3">System Requirements</h4>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-gray-600">Web server (Apache/Nginx)</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-gray-600">FreeRadius server</span>
                        </div>
                        <!-- More requirements would follow the same pattern -->
                    </div>
                </div>
            </div>

            <!-- Version Info -->
            <div class="bg-gray-50 px-6 py-4 border-t">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-medium text-gray-700">Version Information</h4>
                        <p class="text-sm text-gray-500">PPPoE Manager v2.1.0</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
