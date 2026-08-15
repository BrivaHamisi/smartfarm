<?php
// app/Http/Controllers/MilkRecordController.php

namespace App\Http\Controllers;

use App\Models\Cattle;
use App\Models\MilkProduction;
use Illuminate\Http\Request;

class MilkRecordController extends Controller
{
    public function index()
    {
        $milkProductions = MilkProduction::with('cow')->latest('date')->get();
        return view('cattle.milk-records.index', compact('milkProductions'));
    }

    public function create()
    {
        $cattle = Cattle::all(); // already scoped to user via trait
        return view('cattle.milk-records.create', compact('cattle'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cow_id'    => 'required|exists:cattle,id',
            'date'      => 'required|date',
            'morning'   => 'required|numeric|min:0',
            'afternoon' => 'required|numeric|min:0',
            'evening'   => 'required|numeric|min:0',
        ]);

        MilkProduction::create($validated);

        return redirect()->route('cattle.milk-records.index')
            ->with('success', 'Milk production record added successfully.');
    }

    public function edit(MilkProduction $milkRecord)
    {
        $cattle = Cattle::all();
        return view('cattle.milk-records.edit', compact('milkRecord', 'cattle'));
    }

    public function update(Request $request, MilkProduction $milkRecord)
    {
        $validated = $request->validate([
            'cow_id'    => 'required|exists:cattle,id',
            'date'      => 'required|date',
            'morning'   => 'required|numeric|min:0',
            'afternoon' => 'required|numeric|min:0',
            'evening'   => 'required|numeric|min:0',
        ]);

        $milkRecord->update($validated);

        return redirect()->route('cattle.milk-records.index')
            ->with('success', 'Milk record updated successfully.');
    }

    public function destroy(MilkProduction $milkRecord)
    {
        $milkRecord->delete();
        return redirect()->route('cattle.milk-records.index')
            ->with('success', 'Milk record deleted.');
    }
}