<x-dlayout>
    <div class="p-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Add New Poultry Record</h3>
            <form action="{{ route('poultry.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="date" id="date" value="{{ today()->toDateString() }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>
                    <div>
                        <label for="chicken_count" class="block text-sm font-medium text-gray-700">Chicken Count</label>
                        <input type="number" name="chicken_count" id="chicken_count" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>
                    <div>
                        <label for="mortalities" class="block text-sm font-medium text-gray-700">Mortalities</label>
                        <input type="number" name="mortalities" id="mortalities" value="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>
                    <div>
                        <label for="eggs_produced" class="block text-sm font-medium text-gray-700">Eggs Produced</label>
                        <input type="number" name="eggs_produced" id="eggs_produced" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>
                    <div>
                        <label for="eggs_sold" class="block text-sm font-medium text-gray-700">Eggs Sold</label>
                        <input type="number" name="eggs_sold" id="eggs_sold" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">Save Record</button>
                    <a href="{{ route('poultry.index') }}" class="ml-4 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-dlayout>