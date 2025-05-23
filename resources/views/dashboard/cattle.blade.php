<x-dlayout>
    <div class="p-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-gray-500">Total Cattle</div>
                        <div class="mt-2 flex items-baseline">
                            <span class="text-2xl font-semibold text-gray-900">{{ $cattle->count() }}</span>
                            <span class="ml-2 text-sm text-gray-500">Head</span>
                        </div>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-lg">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-gray-500">Milk Today</div>
                        <div class="mt-2 flex items-baseline">
                            <span class="text-2xl font-semibold text-gray-900">{{ $milkToday }}</span>
                            <span class="ml-2 text-sm text-gray-500">Liters</span>
                        </div>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
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
            <div class="bg-white rounded-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-gray-500">Active Cows</div>
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
        </div>

        <!-- Cattle Table -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Cattle Records</h3>
                    <a href="{{ route('cattle.create') }}" class="text-sm text-emerald-600 hover:text-emerald-700">Add New Cattle</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Breed</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Milk Today</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($cattle as $cow)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $cow->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cow->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cow->breed }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cow->gender }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cow->milkProductions->where('date', today())->sum('morning') + $cow->milkProductions->where('date', today())->sum('afternoon') + $cow->milkProductions->where('date', today())->sum('evening') }} L</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-dlayout>