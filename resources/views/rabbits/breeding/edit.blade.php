<x-dlayout>
    <div class="p-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 max-w-2xl">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Edit Rabbit Breeding Record</h3>
            <form action="{{ route('rabbits.breeding.update', $breeding) }}" method="POST">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Doe ID</label>
                        <select name="doe_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                            @foreach($does as $doe)
                                <option value="{{ $doe->rabbit_id }}" @selected(old('doe_id', $breeding->doe_id) === $doe->rabbit_id)>{{ $doe->rabbit_id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Buck ID</label>
                        <select name="buck_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                            @foreach($bucks as $buck)
                                <option value="{{ $buck->rabbit_id }}" @selected(old('buck_id', $breeding->buck_id) === $buck->rabbit_id)>{{ $buck->rabbit_id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mating Date</label>
                        <input type="date" name="mating_date" value="{{ old('mating_date', $breeding->mating_date->format('Y-m-d')) }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Litter Size <span class="text-gray-400 text-xs">(after kindling)</span></label>
                        <input type="number" name="litter_size" min="0" value="{{ old('litter_size', $breeding->litter_size) }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="px-5 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 font-medium">Update</button>
                    <a href="{{ route('rabbits.index') }}" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-medium">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-dlayout>