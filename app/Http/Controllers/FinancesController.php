<?php

namespace App\Http\Controllers;

use App\Models\Finances;
use Illuminate\Http\Request;

class FinancesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function finances()
    {
        $financials = Finances::all();
        $totalIncome = $financials->where('type', 'income')->sum('amount');
        $totalExpenses = $financials->where('type', 'expense')->sum('amount');
        $netProfit = $totalIncome - $totalExpenses;
        $todayExpenses = $financials->where('type', 'expense')->where('date', today())->sum('amount');

        return view('dashboard.finances', compact('financials', 'totalIncome', 'totalExpenses', 'netProfit', 'todayExpenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finances.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:expense,income',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|in:feeds,medication,human_resource,sales',
            'date' => 'required|date',
        ]);

        Finances::create($request->only(['type', 'amount', 'category', 'date']));

        return redirect()->route('finances.index')->with('success', 'Financial record added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Finances $finances)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Finances $finances)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Finances $finances)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Finances $finances)
    {
        //
    }
}
