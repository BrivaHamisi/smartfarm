<?php
// app/Http/Controllers/FinancesController.php

namespace App\Http\Controllers;

use App\Models\Finances;
use Illuminate\Http\Request;

class FinancesController extends Controller
{
    public function finances()
    {
        $financials = Finances::all(); // user scoped via trait
        $totalIncome = $financials->where('type', 'income')->sum('amount');
        $totalExpenses = $financials->where('type', 'expense')->sum('amount');
        $netProfit = $totalIncome - $totalExpenses;
        $todayExpenses = $financials->where('type', 'expense')
            ->filter(fn($f) => $f->date->isToday())->sum('amount');

        return view('dashboard.finances', compact('financials', 'totalIncome', 'totalExpenses', 'netProfit', 'todayExpenses'));
    }

    public function create()
    {
        return view('finances.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'        => 'required|in:expense,income',
            'amount'      => 'required|numeric|min:0',
            'category'    => 'required|in:feeds,medication,human_resource,sales,dorper,crops,rabbits,other',
            'date'        => 'required|date',
            'description' => 'nullable|string|max:500',
            'source'      => 'nullable|string|max:255', // e.g. "Dorper Lamb Sale"
        ]);

        Finances::create($request->only(['type', 'amount', 'category', 'date', 'description', 'source']));

        return redirect()->route('finances.index')->with('success', 'Financial record added successfully!');
    }

    public function edit(Finances $finances)
    {
        return view('finances.edit', compact('finances'));
    }

    public function update(Request $request, Finances $finances)
    {
        $request->validate([
            'type'        => 'required|in:expense,income',
            'amount'      => 'required|numeric|min:0',
            'category'    => 'required|in:feeds,medication,human_resource,sales,dorper,crops,rabbits,other',
            'date'        => 'required|date',
            'description' => 'nullable|string|max:500',
            'source'      => 'nullable|string|max:255',
        ]);

        $finances->update($request->only(['type', 'amount', 'category', 'date', 'description', 'source']));

        return redirect()->route('finances.index')->with('success', 'Financial record updated successfully!');
    }

    public function destroy(Finances $finances)
    {
        $finances->delete();
        return redirect()->route('finances.index')->with('success', 'Financial record deleted.');
    }
}