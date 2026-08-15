<x-dlayout>
    <div class="p-6 space-y-6">
        @if(session('success'))<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>@endif

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Total Fields</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $fields->count() }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Total Acreage</p>
                <p class="text-3xl font-bold text-emerald-600 mt-1">{{ number_format($totalAcreage, 1) }} <span class="text-sm font-normal text-gray-400">acres</span></p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Total Harvest</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ number_format($totalHarvest, 1) }}</p>
            </div>
        </div>

        @unless(session('is_worker'))
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('crops.fields.create') }}" class="px-4 py-2 bg-emerald-600 text-white text-sm rounded-xl hover:bg-emerald-700 font-medium">+ Add Field</a>
            <a href="{{ route('crops.inputs.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-xl hover:bg-blue-700 font-medium">+ Add Fertilizer / Pesticide</a>
            <a href="{{ route('crops.harvests.create') }}" class="px-4 py-2 bg-amber-600 text-white text-sm rounded-xl hover:bg-amber-700 font-medium">+ Add Harvest</a>
        </div>
        @endunless

        {{-- Fields Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-5 border-b border-gray-50"><h3 class="font-semibold text-gray-900">Field Information</h3></div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead><tr class="border-b border-gray-50">
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Field Name / ID</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Crop Planted</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Acreage</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Planting Date</th>
                        @unless(session('is_worker'))<th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>@endunless
                    </tr></thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($fields as $field)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4 text-sm font-medium text-gray-900">{{ $field->field_name }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $field->crop_planted }}</td>
                            <td class="px-5 py-4 text-sm text-gray-700">{{ $field->acreage }} acres</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $field->planting_date->format('d M Y') }}</td>
                            @unless(session('is_worker'))
                            <td class="px-5 py-4 flex gap-3">
                                <a href="{{ route('crops.fields.edit', $field) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <form action="{{ route('crops.fields.destroy', $field) }}" method="POST" onsubmit="return confirm('Delete this field and all its records?')">
                                    @csrf @method('DELETE')
                                    <button class="text-sm text-red-500 hover:text-red-700 font-medium">Delete</button>
                                </form>
                            </td>
                            @endunless
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-5 py-10 text-center text-sm text-gray-400">No fields added yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Harvests --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-5 border-b border-gray-50"><h3 class="font-semibold text-gray-900">Recent Harvest Records</h3></div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead><tr class="border-b border-gray-50">
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Crop</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Field</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Quantity</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Unit</th>
                        @unless(session('is_worker'))<th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>@endunless
                    </tr></thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($recentHarvests as $harvest)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $harvest->date->format('d M Y') }}</td>
                            <td class="px-5 py-4 text-sm font-medium text-gray-900">{{ $harvest->crop }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $harvest->field->field_name ?? '—' }}</td>
                            <td class="px-5 py-4 text-sm font-semibold text-emerald-700">{{ number_format($harvest->quantity_harvested, 1) }}</td>
                            <td class="px-5 py-4 text-sm text-gray-500">{{ $harvest->unit }}</td>
                            @unless(session('is_worker'))
                            <td class="px-5 py-4 flex gap-3">
                                <a href="{{ route('crops.harvests.edit', $harvest) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <form action="{{ route('crops.harvests.destroy', $harvest) }}" method="POST" onsubmit="return confirm('Delete this harvest record?')">
                                    @csrf @method('DELETE')
                                    <button class="text-sm text-red-500 hover:text-red-700 font-medium">Delete</button>
                                </form>
                            </td>
                            @endunless
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-5 py-10 text-center text-sm text-gray-400">No harvests recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dlayout>