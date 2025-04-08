<?php

namespace App\Http\Controllers;

use App\Models\Cattle;
use Illuminate\Http\Request;
use App\Models\MilkProduction;

class MilkRecordController extends Controller
{
    public function index()
    {
        $milkProductions = MilkProduction::with('cow')->latest()->get();
        return view('cattle.milk-records.index', compact('milkProductions'));
    }

    public function create()
    {
        $cattle = Cattle::all(); // Fetch all cattle for the dropdown
        return view('cattle.milk-records.create', compact('cattle'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cow_id' => 'required|exists:cattle,id',
            'date' => 'required|date',
            'morning' => 'required|numeric|min:0',
            'afternoon' => 'required|numeric|min:0',
            'evening' => 'required|numeric|min:0',
        ]);

        MilkProduction::create($validated);

        return redirect()->route('cattle.milk-records.index')
            ->with('success', 'Milk production record added successfully.');
    }
}
