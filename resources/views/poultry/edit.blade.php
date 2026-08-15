<x-dlayout>
    <div class="p-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 max-w-2xl">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Edit Poultry Record</h3>
            <form action="{{ route('poultry.update', $poultry) }}" method="POST">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date" name="date" value="{{ old('date', $poultry->date->format('Y-m-d')) }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        @error('date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Chicken Count</label>
                        <input type="number" name="chicken_count" value="{{ old('chicken_count', $poultry->chicken_count) }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        @error('chicken_count')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Eggs Produced</label>
                        <input type="number" name="eggs_produced" value="{{ old('eggs_produced', $poultry->eggs_produced) }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        @error('eggs_produced')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Eggs Sold</label>
                        <input type="number" name="eggs_sold" value="{{ old('eggs_sold', $poultry->eggs_sold) }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        @error('eggs_sold')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mortalities</label>
                        <input type="number" name="mortalities" value="{{ old('mortalities', $poultry->mortalities) }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        @error('mortalities')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="px-5 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 font-medium">Update</button>
                    <a href="{{ route('poultry.index') }}" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-medium">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-dlayout>