<x-dlayout>
    <div class="p-6 space-y-6">
        @if(session('success'))<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>@endif

        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Total Workers</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $workers->count() }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Total Salaries</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($totalSalaries) }}<span class="text-sm font-normal text-gray-400 ml-1">KES</span></p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">New Hires</p>
                <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $newHires }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-5 border-b border-gray-50 flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Workers</h3>
                @unless(session('is_worker'))
                <a href="{{ route('workers.create') }}" class="text-xs bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-lg hover:bg-emerald-100">+ Add Worker</a>
                @endunless
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead><tr class="border-b border-gray-50">
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Name</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Position</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Phone</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Salary</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Hired</th>
                        @unless(session('is_worker'))<th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>@endunless
                    </tr></thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($workers as $worker)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4 text-sm font-medium text-gray-900">{{ $worker->name }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $worker->position }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $worker->phone }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $worker->email }}</td>
                            <td class="px-5 py-4 text-sm font-semibold text-gray-800">{{ number_format($worker->salary) }} KES</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $worker->employment_date->format('d M Y') }}</td>
                            @unless(session('is_worker'))
                            <td class="px-5 py-4 text-sm flex gap-3">
                                <a href="{{ route('workers.edit', $worker) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <form action="{{ route('workers.destroy', $worker) }}" method="POST" onsubmit="return confirm('Remove this worker and their login access?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Delete</button>
                                </form>
                            </td>
                            @endunless
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-5 py-8 text-center text-sm text-gray-400">No workers added yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dlayout>