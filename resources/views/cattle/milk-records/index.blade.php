<x-dlayout>
    <div class="p-6 space-y-6">
        @if(session('success'))<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>@endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-5 border-b border-gray-50 flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Milk Production Records</h3>
                @unless(session('is_worker'))
                <a href="{{ route('cattle.milk-records.create') }}" class="text-xs bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-lg hover:bg-emerald-100">+ Add Record</a>
                @endunless
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead><tr class="border-b border-gray-50">
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Cow</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Morning</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Afternoon</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Evening</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Total</th>
                        @unless(session('is_worker'))<th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>@endunless
                    </tr></thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($milkProductions as $record)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4 text-sm text-gray-900">{{ $record->date->format('d M Y') }}</td>
                            <td class="px-5 py-4 text-sm font-medium text-gray-900">{{ $record->cow->name ?? 'Cow #'.$record->cow_id }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $record->morning }} L</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $record->afternoon }} L</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $record->evening }} L</td>
                            <td class="px-5 py-4 text-sm font-bold text-emerald-700">{{ $record->total_yield }} L</td>
                            @unless(session('is_worker'))
                            <td class="px-5 py-4 text-sm flex gap-3">
                                <a href="{{ route('cattle.milk-records.edit', $record) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <form action="{{ route('cattle.milk-records.destroy', $record) }}" method="POST" onsubmit="return confirm('Delete this milk record?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Delete</button>
                                </form>
                            </td>
                            @endunless
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-5 py-8 text-center text-sm text-gray-400">No milk records yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dlayout>