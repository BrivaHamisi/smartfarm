<x-dlayout>
    <div class="p-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 max-w-xl">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Edit Field — {{ $field->field_name }}</h3>
            <form action="{{ route('crops.fields.update', $field) }}" method="POST">
                @csrf @method('PUT')
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Field Name / ID</label>
                        <input type="text" name="field_name" value="{{ old('field_name', $field->field_name) }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Crop Planted</label>
                        <input type="text" name="crop_planted" value="{{ old('crop_planted', $field->crop_planted) }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Acreage (acres)</label>
                        <input type="number" step="0.01" name="acreage" value="{{ old('acreage', $field->acreage) }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Planting Date</label>
                        <input type="date" name="planting_date" value="{{ old('planting_date', $field->planting_date->format('Y-m-d')) }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="px-5 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 font-medium">Update</button>
                    <a href="{{ route('crops.index') }}" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-medium">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-dlayout>