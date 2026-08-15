<x-dlayout>
    <div class="p-6 space-y-6">
        @if(session('success'))<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">{{ session('error') }}</div>@endif

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Total Animals</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $animals->count() }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Ewes / Lambs</p>
                <p class="text-3xl font-bold text-pink-600 mt-1">{{ $ewes }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Rams</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $rams }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Upcoming Lambings</p>
                <p class="text-3xl font-bold text-amber-600 mt-1">{{ $upcomingLambings }}</p>
            </div>
        </div>

        {{-- Quick Links --}}
        @unless(session('is_worker'))
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('dorper.animals.create') }}" class="px-4 py-2 bg-emerald-600 text-white text-sm rounded-xl hover:bg-emerald-700 font-medium">+ Add Animal</a>
            <a href="{{ route('dorper.breeding.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-xl hover:bg-blue-700 font-medium">+ Add Breeding Record</a>
            <a href="{{ route('dorper.financials') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-xl hover:bg-gray-200 font-medium">View Financials</a>
        </div>
        @endunless

        {{-- Animal Identification Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-5 border-b border-gray-50">
                <h3 class="font-semibold text-gray-900">Animal Identification Records</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead><tr class="border-b border-gray-50">
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tag #</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Date of Birth</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Breed / Lineage</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Gender</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Weight (kg)</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Notes</th>
                        @unless(session('is_worker'))<th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>@endunless
                    </tr></thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($animals as $animal)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4 text-sm font-mono font-bold text-gray-900">{{ $animal->tag_number }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $animal->date_of_birth->format('d M Y') }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $animal->breed_lineage }}</td>
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                                    {{ $animal->gender === 'ram' ? 'bg-blue-100 text-blue-700' : ($animal->gender === 'ewe' ? 'bg-pink-100 text-pink-700' : 'bg-gray-100 text-gray-700') }}">
                                    {{ ucfirst($animal->gender) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-700">{{ $animal->weight_kg }} kg</td>
                            <td class="px-5 py-4 text-sm text-gray-500">{{ Str::limit($animal->notes, 40) ?? '—' }}</td>
                            @unless(session('is_worker'))
                            <td class="px-5 py-4 flex gap-3">
                                <a href="{{ route('dorper.animals.edit', $animal) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <form action="{{ route('dorper.animals.destroy', $animal) }}" method="POST" onsubmit="return confirm('Delete this animal?')">
                                    @csrf @method('DELETE')
                                    <button class="text-sm text-red-500 hover:text-red-700 font-medium">Delete</button>
                                </form>
                            </td>
                            @endunless
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-5 py-10 text-center text-sm text-gray-400">No animals recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Breeding Records Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-5 border-b border-gray-50">
                <h3 class="font-semibold text-gray-900">Breeding Records</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead><tr class="border-b border-gray-50">
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Ewe Tag</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Ram Tag</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Mating Date</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Expected Lambing</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Lambing Date</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Lambs Born</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        @unless(session('is_worker'))<th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>@endunless
                    </tr></thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($breedingRecords as $record)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4 text-sm font-mono font-bold text-gray-900">{{ $record->ewe_tag }}</td>
                            <td class="px-5 py-4 text-sm font-mono text-gray-700">{{ $record->ram_tag }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $record->mating_date->format('d M Y') }}</td>
                            <td class="px-5 py-4 text-sm font-medium {{ $record->expected_lambing_date->isPast() && !$record->lambing_date ? 'text-red-600' : 'text-gray-700' }}">
                                {{ $record->expected_lambing_date->format('d M Y') }}
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $record->lambing_date ? $record->lambing_date->format('d M Y') : '—' }}</td>
                            <td class="px-5 py-4 text-sm text-gray-700">{{ $record->lambs_born ?? '—' }}</td>
                            <td class="px-5 py-4">
                                @if($record->lambing_date)
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">Lambed</span>
                                @elseif($record->expected_lambing_date->isPast())
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Overdue</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">Pending</span>
                                @endif
                            </td>
                            @unless(session('is_worker'))
                            <td class="px-5 py-4 flex gap-3">
                                <a href="{{ route('dorper.breeding.edit', $record) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <form action="{{ route('dorper.breeding.destroy', $record) }}" method="POST" onsubmit="return confirm('Delete this record?')">
                                    @csrf @method('DELETE')
                                    <button class="text-sm text-red-500 hover:text-red-700 font-medium">Delete</button>
                                </form>
                            </td>
                            @endunless
                        </tr>
                        @empty
                        <tr><td colspan="8" class="px-5 py-10 text-center text-sm text-gray-400">No breeding records yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dlayout>