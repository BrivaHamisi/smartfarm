<x-dlayout>
    <div class="p-6 space-y-6">
        @if(session('success'))<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>@endif

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Total Calves</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $calves->count() }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">New This Month</p>
                <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $newCalves }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Male</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $maleCalves }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Female</p>
                <p class="text-3xl font-bold text-pink-600 mt-1">{{ $femaleCalves }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-5 border-b border-gray-50 flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Calf Records</h3>
                @unless(session('is_worker'))
                <a href="{{ route('calves.create') }}" class="text-xs bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-lg hover:bg-emerald-100">+ Add Calf</a>
                @endunless
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead><tr class="border-b border-gray-50">
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Name</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Mother</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">DOB</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Breed</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Gender</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Weight</th>
                        @unless(session('is_worker'))<th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>@endunless
                    </tr></thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($calves as $calf)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4 text-sm font-medium text-gray-900">{{ $calf->name }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $calf->cattle->name ?? '—' }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $calf->dob->format('d M Y') }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $calf->breed }}</td>
                            <td class="px-5 py-4"><span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $calf->gender === 'female' ? 'bg-pink-100 text-pink-700' : 'bg-blue-100 text-blue-700' }}">{{ ucfirst($calf->gender) }}</span></td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $calf->weight_kg }} kg</td>
                            {{-- @unless(session('is_worker')) --}}
                            <td class="px-5 py-4 text-sm flex gap-3">
                                <a href="{{ route('calves.edit', $calf) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <form action="{{ route('calves.destroy', $calf) }}" method="POST" onsubmit="return confirm('Delete this calf record?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Delete</button>
                                </form>
                            </td>
                            {{-- @endunless --}}
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-5 py-8 text-center text-sm text-gray-400">No calf records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dlayout>