<x-dlayout>
    <div class="p-6 space-y-6">
        @if(session('success'))<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>@endif

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Total Income</p>
                <p class="text-3xl font-bold text-emerald-600 mt-1">{{ number_format($totalIncome) }}<span class="text-sm font-normal text-gray-400 ml-1">KES</span></p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Total Expenses</p>
                <p class="text-3xl font-bold text-red-600 mt-1">{{ number_format($totalExpenses) }}<span class="text-sm font-normal text-gray-400 ml-1">KES</span></p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Net Profit</p>
                <p class="text-3xl font-bold {{ $netProfit >= 0 ? 'text-emerald-600' : 'text-red-600' }} mt-1">{{ number_format($netProfit) }}<span class="text-sm font-normal text-gray-400 ml-1">KES</span></p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Today's Expenses</p>
                <p class="text-3xl font-bold text-amber-600 mt-1">{{ number_format($todayExpenses) }}<span class="text-sm font-normal text-gray-400 ml-1">KES</span></p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-5 border-b border-gray-50 flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Financial Records</h3>
                @unless(session('is_worker'))
                <a href="{{ route('finances.create') }}" class="text-xs bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-lg hover:bg-emerald-100">+ Add Transaction</a>
                @endunless
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead><tr class="border-b border-gray-50">
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Type</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Category</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Amount</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Description</th>
                        @unless(session('is_worker'))<th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>@endunless
                    </tr></thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($financials as $record)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4 text-sm text-gray-900">{{ $record->date->format('d M Y') }}</td>
                            <td class="px-5 py-4"><span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $record->type === 'income' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">{{ ucfirst($record->type) }}</span></td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $record->category)) }}</td>
                            <td class="px-5 py-4 text-sm font-semibold {{ $record->type === 'income' ? 'text-emerald-700' : 'text-red-700' }}">{{ number_format($record->amount) }} KES</td>
                            <td class="px-5 py-4 text-sm text-gray-500">{{ $record->description ?? '—' }}</td>
                            @unless(session('is_worker'))
                            <td class="px-5 py-4 text-sm flex gap-3">
                                <a href="{{ route('finances.edit', $record) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <form action="{{ route('finances.destroy', $record) }}" method="POST" onsubmit="return confirm('Delete this record?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Delete</button>
                                </form>
                            </td>
                            @endunless
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-5 py-8 text-center text-sm text-gray-400">No financial records yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dlayout>