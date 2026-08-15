<x-dlayout>
    <div class="p-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 max-w-xl">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Edit Rabbit — {{ $rabbit->rabbit_id }}</h3>
            <form action="{{ route('rabbits.update', $rabbit) }}" method="POST">
                @csrf @method('PUT')
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rabbit ID</label>
                        <input type="text" name="rabbit_id" value="{{ old('rabbit_id', $rabbit->rabbit_id) }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        @error('rabbit_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Breed</label>
                        <input type="text" name="breed" value="{{ old('breed', $rabbit->breed) }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                        <select name="gender" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                            <option value="doe"  @selected(old('gender', $rabbit->gender) === 'doe')>Doe (Female)</option>
                            <option value="buck" @selected(old('gender', $rabbit->gender) === 'buck')>Buck (Male)</option>
                        </select>
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