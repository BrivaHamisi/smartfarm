<x-app-layout>
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar Navigation -->
        <div class="w-64 bg-white shadow-lg">
            <div class="flex items-center justify-center h-16 border-b">
                <span class="text-2xl font-bold text-emerald-600">FarmTracker</span>
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

            <!-- Dashboard Content -->
            <div class="p-8">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-lg p-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-medium text-gray-500">Total Milk Today</div>
                                <div class="mt-2 flex items-baseline">
                                    <span class="text-2xl font-semibold text-gray-900">256</span>
                                    <span class="ml-2 text-sm text-gray-500">Liters</span>
                                </div>
                            </div>
                            <div class="p-3 bg-emerald-50 rounded-lg">
                                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- [Previous stats cards follow same pattern with different icons and colors] -->

                <div class="bg-white rounded-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-medium text-gray-500">Eggs Collected</div>
                            <div class="mt-2 flex items-baseline">
                                <span class="text-2xl font-semibold text-gray-900">142</span>
                                <span class="ml-2 text-sm text-gray-500">Today</span>
                            </div>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-medium text-gray-500">Active Cows</div>
                            <div class="mt-2 flex items-baseline">
                                <span class="text-2xl font-semibold text-gray-900">24</span>
                                <span class="ml-2 text-sm text-emerald-600">+2 new</span>
                            </div>
                        </div>
                        <div class="p-3 bg-amber-50 rounded-lg">
                            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-medium text-gray-500">Due Insemination</div>
                            <div class="mt-2 flex items-baseline">
                                <span class="text-2xl font-semibold text-gray-900">3</span>
                                <span class="ml-2 text-sm text-red-600">Urgent</span>
                            </div>
                        </div>
                        <div class="p-3 bg-red-50 rounded-lg">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Milk Production Section -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Today's Milk Production</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm text-gray-600">Morning</p>
                                    <p class="text-lg font-semibold text-gray-900">98 Liters</p>
                                </div>
                                <div class="flex items-center space-x-2 text-emerald-600">
                                    <span class="text-sm font-medium">+12%</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm text-gray-600">Afternoon</p>
                                    <p class="text-lg font-semibold text-gray-900">86 Liters</p>
                                </div>
                                <div class="flex items-center space-x-2 text-emerald-600">
                                    <span class="text-sm font-medium">+8%</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm text-gray-600">Evening</p>
                                    <p class="text-lg font-semibold text-gray-900">72 Liters</p>
                                </div>
                                <div class="flex items-center space-x-2 text-emerald-600">
                                    <span class="text-sm font-medium">+5%</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tasks and Alerts -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Upcoming Tasks</h3>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4 p-4 bg-red-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-lg bg-red-100 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Insemination Due</p>
                                    <p class="text-sm text-gray-500">Cow #245 - Schedule: Today</p>
                                </div>
                                <button class="px-3 py-1 bg-red-100 text-red-600 rounded-lg text-sm font-medium">
                                    Urgent
                                </button>
                            </div>

                            <div class="flex items-center space-x-4 p-4 bg-amber-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-lg bg-amber-100 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Vaccination Check</p>
                                    <p class="text-sm text-gray-500">Poultry Section B - Due Tomorrow</p>
                                </div>
                                <button class="px-3 py-1 bg-amber-100 text-amber-600 rounded-lg text-sm font-medium">
                                    Pending
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Records Table -->
                <div class="bg-white rounded-lg shadow-sm lg:col-span-2">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Recent Records</h3>
                            <button class="text-sm text-emerald-600 hover:text-emerald-700">View all records</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">COW245</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Milk Production</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Morning Collection: 12L</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Today 6:00 AM</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                                Recorded
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">PLT001</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Poultry</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Eggs Collected: 142</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Today 7:30 AM</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                                Recorded
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">COW238</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Insemination</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Scheduled for tomorrow</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Tomorrow</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                                                Pending
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>