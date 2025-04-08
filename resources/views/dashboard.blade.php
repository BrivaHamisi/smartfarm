<x-dlayout>
    <div class="p-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-gray-500">Total Milk Today</div>
                        <div class="mt-2 flex items-baseline">
                            <span class="text-2xl font-semibold text-gray-900">{{ $milkToday }}</span>
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
            <div class="bg-white rounded-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-gray-500">Eggs Collected</div>
                        <div class="mt-2 flex items-baseline">
                            <span class="text-2xl font-semibold text-gray-900">{{ $eggsToday }}</span>
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
                        <div class="text-sm font-medium text-gray-500">Active Cattle</div>
                        <div class="mt-2 flex items-baseline">
                            <span class="text-2xl font-semibold text-gray-900">{{ $activeCows }}</span>
                            <span class="ml-2 text-sm text-emerald-600">+{{ $newCows }} new</span>
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
                            <span class="text-2xl font-semibold text-gray-900">{{ $dueInseminations }}</span>
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
                                <p class="text-lg font-semibold text-gray-900">{{ $morningMilk }} Liters</p>
                            </div>
                            <div class="flex items-center space-x-2 text-emerald-600">
                                <span class="text-sm font-medium">{{ $morningChange >= 0 ? '+' : '' }}{{ $morningChange }}%</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $morningChange >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-600">Afternoon</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $afternoonMilk }} Liters</p>
                            </div>
                            <div class="flex items-center space-x-2 text-emerald-600">
                                <span class="text-sm font-medium">{{ $afternoonChange >= 0 ? '+' : '' }}{{ $afternoonChange }}%</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $afternoonChange >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-600">Evening</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $eveningMilk }} Liters</p>
                            </div>
                            <div class="flex items-center space-x-2 text-emerald-600">
                                <span class="text-sm font-medium">{{ $eveningChange >= 0 ? '+' : '' }}{{ $eveningChange }}%</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $eveningChange >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"></path>
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
                        @foreach ($tasks as $task)
                            <div class="flex items-center space-x-4 p-4 {{ $task->urgent ? 'bg-red-50' : 'bg-amber-50' }} rounded-lg">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-lg {{ $task->urgent ? 'bg-red-100' : 'bg-amber-100' }} flex items-center justify-center">
                                        <svg class="h-5 w-5 {{ $task->urgent ? 'text-red-600' : 'text-amber-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $task->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $task->details }}</p>
                                </div>
                                <button class="px-3 py-1 {{ $task->urgent ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600' }} rounded-lg text-sm font-medium">
                                    {{ $task->urgent ? 'Urgent' : 'Pending' }}
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Records Table -->
            <div class="bg-white rounded-lg shadow-sm lg:col-span-2">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Recent Records</h3>
                        <a href="#" class="text-sm text-emerald-600 hover:text-emerald-700">View all records</a>
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
                                @foreach ($recentRecords as $record)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $record->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->category }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->details }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $record->status == 'Recorded' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                                {{ $record->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dlayout>