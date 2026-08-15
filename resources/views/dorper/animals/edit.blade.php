<x-dlayout>
    <div class="p-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 max-w-2xl">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Edit Animal — Tag {{ $animal->tag_number }}</h3>
            <form action="{{ route('dorper.animals.update', $animal) }}" method="POST">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tag Number</label>
                        <input type="text" name="tag_number" value="{{ old('tag_number', $animal->tag_number) }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        @error('tag_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $animal->date_of_birth->format('Y-m-d')) }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Breed / Lineage</label>
                        <input type="text" name="breed_lineage" value="{{ old('breed_lineage', $animal->breed_lineage) }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                        <select name="gender" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                            <option value="ewe"  @selected(old('gender', $animal->gender) === 'ewe')>Ewe (Female)</option>
                            <option value="ram"  @selected(old('gender', $animal->gender) === 'ram')>Ram (Male)</option>
                            <option value="lamb" @selected(old('gender', $animal->gender) === 'lamb')>Lamb</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                        <input type="number" step="0.01" name="weight_kg" value="{{ old('weight_kg', $animal->weight_kg) }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="notes" rows="3"
                                  class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('notes', $animal->notes) }}</textarea>
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="px-5 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 font-medium">Update</button>
                    <a href="{{ route('dorper.index') }}" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-medium">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-dlayout>