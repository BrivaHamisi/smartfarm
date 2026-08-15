<x-dlayout>
    <div class="p-6 space-y-6">
        @if(session('success'))<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>@endif

        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Pending</p>
                <p class="text-3xl font-bold text-amber-500 mt-1">{{ $pending }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Successful</p>
                <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $successful }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Failed</p>
                <p class="text-3xl font-bold text-red-500 mt-1">{{ $failed }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-5 border-b border-gray-50 flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Insemination Records</h3>
                @unless(session('is_worker'))
                <a href="{{ route('inseminations.create') }}" class="text-xs bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-lg hover:bg-emerald-100 font-medium">+ Add Record</a>
                @endunless
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead><tr class="border-b border-gray-50">
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Cow</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Bull / Semen ID</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Expected DOB</th>
                        @unless(session('is_worker'))<th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>@endunless
                    </tr></thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($inseminations as $record)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4 text-sm font-medium text-gray-900">{{ $record->cow->name ?? 'Cow #'.$record->cow_id }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $record->date->format('d M Y') }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $record->bull_number }}</td>
                            <td class="px-5 py-4">
                                @if(is_null($record->successful))
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">Pending</span>
                                @elseif($record->successful)
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">Successful</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Failed</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $record->expected_dob ? $record->expected_dob->format('d M Y') : '—' }}</td>
                            @unless(session('is_worker'))
                            <td class="px-5 py-4 flex gap-3">
                                <a href="{{ route('inseminations.edit', $record) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <form action="{{ route('inseminations.destroy', $record) }}" method="POST" onsubmit="return confirm('Delete this insemination record?')">
                                    @csrf @method('DELETE')
                                    <button class="text-sm text-red-500 hover:text-red-700 font-medium">Delete</button>
                                </form>
                            </td>
                            @endunless
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-5 py-10 text-center text-sm text-gray-400">No insemination records yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dlayout>