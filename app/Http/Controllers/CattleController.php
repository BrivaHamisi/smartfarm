<?php

namespace App\Http\Controllers;

use App\Models\Cattle;
use Illuminate\View\View;
use App\Models\Insemination;
use Illuminate\Http\Request;

class CattleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $cattle = Cattle::with('milkProductions')->get();
        $milkToday = $cattle->sum(fn($cow) => $cow->milkProductions->where('date', today())->sum('morning') + $cow->milkProductions->where('date', today())->sum('afternoon') + $cow->milkProductions->where('date', today())->sum('evening'));
        $dueInseminations = Insemination::where('successful', null)->where('date', '<=', now())->count();
        $activeCows = $cattle->where('gender', 'female')->count();
        $newCows = $cattle->where('created_at', '>=', now()->subMonth())->count();

        return view('dashboard.cattle', compact('cattle', 'milkToday', 'dueInseminations', 'activeCows', 'newCows'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cattle.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'weight_kg' => 'required|numeric|min:0',
            'breed' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
        ]);

        Cattle::create($request->all());

        return redirect()->route('cattle.index')->with('success', 'Cattle added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cattle $cattle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cattle $cattle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cattle $cattle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cattle $cattle)
    {
        //
    }
}
