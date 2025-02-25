<x-app-layout>
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar Navigation -->
        <div class="w-64 bg-white shadow-lg">
            <div class="flex items-center justify-center h-16 border-b">
                <span class="text-2xl font-bold text-emerald-600">Smart Farm</span>
            </div>
            
            <!-- User Profile Section -->
            <div class="p-4 border-b bg-gray-50">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <img src="/api/placeholder/40/40" alt="User Avatar" class="w-10 h-10 rounded-full border-2 border-white shadow-sm">
                        <span class="absolute bottom-0 right-0 h-3 w-3 bg-emerald-500 border-2 border-white rounded-full"></span>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800">John Farmer</h3>
                        <p class="text-xs text-gray-500">Farm Manager</p>
                    </div>
                </div>
            </div>

            <nav class="mt-4">
                <div class="px-4 space-y-1">
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 bg-emerald-50 rounded-lg">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"></path>
                        </svg>
                        <span class="ml-3">Dashboard</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-3 text-gray-600 transition-colors rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        <span class="ml-3">Cattle</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-3 text-gray-600 transition-colors rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                        </svg>
                        <span class="ml-3">Poultry</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-3 text-gray-600 transition-colors rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="ml-3">Finances</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-3 text-gray-600 transition-colors rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="ml-3">Workers</span>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Top Header -->
            <div class="bg-white shadow-sm">
                <div class="flex justify-between items-center px-8 py-4">
                    <div class="flex items-center space-x-4">
                        <button class="bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700 transition duration-150 ease-in-out">
                            {{ __('Add Record') }}
                        </button>
                    </div>
                    <div class="flex items-center space-x-6">
                        <button class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                        <div class="relative">
                            <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{ $slot }}

        </div>
    </div>
</div>
</x-app-layout>