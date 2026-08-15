<x-dlayout>
    <div class="p-6 space-y-6">
        @if(session('success'))<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>@endif

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Total Rabbits</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $rabbits->count() }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Does (Female)</p>
                <p class="text-3xl font-bold text-pink-600 mt-1">{{ $does }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Bucks (Male)</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $bucks }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Upcoming Kindlings</p>
                <p class="text-3xl font-bold text-amber-600 mt-1">{{ $upcomingKindlings }}</p>
            </div>
        </div>

        @unless(session('is_worker'))
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('rabbits.create') }}" class="px-4 py-2 bg-emerald-600 text-white text-sm rounded-xl hover:bg-emerald-700 font-medium">+ Add Rabbit</a>
            <a href="{{ route('rabbits.breeding.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-xl hover:bg-blue-700 font-medium">+ Add Breeding Record</a>
        </div>
        @endunless

        {{-- Rabbit Identification --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-5 border-b border-gray-50"><h3 class="font-semibold text-gray-900">Rabbit Identification</h3></div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead><tr class="border-b border-gray-50">
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Rabbit ID</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Breed</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Gender</th>
                        @unless(session('is_worker'))<th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>@endunless
                    </tr></thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($rabbits as $rabbit)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4 text-sm font-mono font-bold text-gray-900">{{ $rabbit->rabbit_id }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $rabbit->breed }}</td>
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $rabbit->gender === 'doe' ? 'bg-pink-100 text-pink-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ ucfirst($rabbit->gender) }}
                                </span>
                            </td>
                            @unless(session('is_worker'))
                            <td class="px-5 py-4 flex gap-3">
                                <a href="{{ route('rabbits.edit', $rabbit) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <form action="{{ route('rabbits.destroy', $rabbit) }}" method="POST" onsubmit="return confirm('Delete this rabbit?')">
                                    @csrf @method('DELETE')
                                    <button class="text-sm text-red-500 hover:text-red-700 font-medium">Delete</button>
                                </form>
                            </td>
                            @endunless
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-5 py-10 text-center text-sm text-gray-400">No rabbits recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Breeding Records --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-5 border-b border-gray-50"><h3 class="font-semibold text-gray-900">Breeding Records</h3></div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead><tr class="border-b border-gray-50">
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Doe ID</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Buck ID</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Mating Date</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Expected Kindling</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Litter Size</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        @unless(session('is_worker'))<th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>@endunless
                    </tr></thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($breedingRecords as $record)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4 text-sm font-mono font-bold text-gray-900">{{ $record->doe_id }}</td>
                            <td class="px-5 py-4 text-sm font-mono text-gray-700">{{ $record->buck_id }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $record->mating_date->format('d M Y') }}</td>
                            <td class="px-5 py-4 text-sm font-medium {{ $record->expected_kindling_date->isPast() && is_null($record->litter_size) ? 'text-red-600' : 'text-gray-700' }}">
                                {{ $record->expected_kindling_date->format('d M Y') }}
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-700">{{ $record->litter_size ?? '—' }}</td>
                            <td class="px-5 py-4">
                                @if(!is_null($record->litter_size))
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">Kindled</span>
                                @elseif($record->expected_kindling_date->isPast())
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Overdue</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">Pending</span>
                                @endif
                            </td>
                            @unless(session('is_worker'))
                            <td class="px-5 py-4 flex gap-3">
                                <a href="{{ route('rabbits.breeding.edit', $record) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <form action="{{ route('rabbits.breeding.destroy', $record) }}" method="POST" onsubmit="return confirm('Delete this record?')">
                                    @csrf @method('DELETE')
                                    <button class="text-sm text-red-500 hover:text-red-700 font-medium">Delete</button>
                                </form>
                            </td>
                            @endunless
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-5 py-10 text-center text-sm text-gray-400">No breeding records yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dlayout>