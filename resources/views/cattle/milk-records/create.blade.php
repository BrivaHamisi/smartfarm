<x-dlayout>
    <div class="bg-white rounded-lg shadow-sm p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-6">Add Milk Production</h3>

    <form method="POST" action="{{ route('cattle.milk-records.store') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Cattle Selection -->
            <div>
                <label for="cow_id" class="block text-sm font-medium text-gray-700">Cattle</label>
                <select name="cow_id" id="cow_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" required>
                    <option value="">Select Cattle</option>
                    @foreach ($cattle as $cow)
                        <option value="{{ $cow->id }}">{{ $cow->name ?? 'Cattle #' . $cow->id }}</option>
                    @endforeach
                </select>
                @error('cow_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Date -->
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="date" id="date" value="{{ old('date', now()->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" required>
                @error('date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Morning Yield -->
            <div>
                <label for="morning" class="block text-sm font-medium text-gray-700">Morning Yield (Liters)</label>
                <input type="number" name="morning" id="morning" step="0.01" value="{{ old('morning', 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" required>
                @error('morning') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Afternoon Yield -->
            <div>
                <label for="afternoon" class="block text-sm font-medium text-gray-700">Afternoon Yield (Liters)</label>
                <input type="number" name="afternoon" id="afternoon" step="0.01" value="{{ old('afternoon', 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" required>
                @error('afternoon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Evening Yield -->
            <div>
                <label for="evening" class="block text-sm font-medium text-gray-700">Evening Yield (Liters)</label>
                <input type="number" name="evening" id="evening" step="0.01" value="{{ old('evening', 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" required>
                @error('evening') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-6 flex items-center space-x-4">
            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                Save Record
            </button>
            <a href="{{ route('cattle.milk-records.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
</x-dlayout>