<x-dlayout>
    <div class="p-6 space-y-6">
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Dorper Income</p>
                <p class="text-3xl font-bold text-emerald-600 mt-1">{{ number_format($income) }} <span class="text-sm font-normal text-gray-400">KES</span></p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Dorper Expenses</p>
                <p class="text-3xl font-bold text-red-600 mt-1">{{ number_format($expenses) }} <span class="text-sm font-normal text-gray-400">KES</span></p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Net</p>
                <p class="text-3xl font-bold {{ ($income - $expenses) >= 0 ? 'text-emerald-600' : 'text-red-600' }} mt-1">{{ number_format($income - $expenses) }} <span class="text-sm font-normal text-gray-400">KES</span></p>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-5 border-b border-gray-50 flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Dorper Financial Records</h3>
                @unless(session('is_worker'))
                <a href="{{ route('finances.create') }}" class="text-xs bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-lg hover:bg-emerald-100 font-medium">+ Add Transaction</a>
                @endunless
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead><tr class="border-b border-gray-50">
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Type</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Amount</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Description</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($financials as $f)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $f->date->format('d M Y') }}</td>
                            <td class="px-5 py-4"><span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $f->type === 'income' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">{{ ucfirst($f->type) }}</span></td>
                            <td class="px-5 py-4 text-sm font-semibold {{ $f->type === 'income' ? 'text-emerald-700' : 'text-red-700' }}">{{ number_format($f->amount) }} KES</td>
                            <td class="px-5 py-4 text-sm text-gray-500">{{ $f->description ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-5 py-10 text-center text-sm text-gray-400">No dorper financial records yet. Add transactions with category "Dorper".</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dlayout>