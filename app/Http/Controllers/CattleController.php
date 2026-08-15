<?php
// app/Http/Controllers/CattleController.php

namespace App\Http\Controllers;

use App\Models\Cattle;
use App\Models\Insemination;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CattleController extends Controller
{
    public function index(): View
    {
        $cattle = Cattle::with('milkProductions')->get(); // user_id scoped via trait
        $milkToday = $cattle->sum(fn($cow) =>
            $cow->milkProductions->where('date', today())->sum('morning') +
            $cow->milkProductions->where('date', today())->sum('afternoon') +
            $cow->milkProductions->where('date', today())->sum('evening')
        );
        $dueInseminations = Insemination::where('successful', null)->where('date', '<=', now())->count();
        $activeCows = $cattle->where('gender', 'female')->count();
        $newCows = $cattle->where('created_at', '>=', now()->subMonth())->count();

        return view('dashboard.cattle', compact('cattle', 'milkToday', 'dueInseminations', 'activeCows', 'newCows'));
    }

    public function create()
    {
        return view('cattle.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'age'       => 'required|integer|min:0',
            'weight_kg' => 'required|numeric|min:0',
            'breed'     => 'required|string|max:255',
            'gender'    => 'required|in:male,female',
        ]);

        Cattle::create($request->only(['name', 'age', 'weight_kg', 'breed', 'gender']));

        return redirect()->route('cattle.index')->with('success', 'Cattle added successfully!');
    }

    public function edit(Cattle $cattle)
    {
        // The global scope ensures only the owner's cattle is resolved
        return view('cattle.edit', compact('cattle'));
    }

    public function update(Request $request, Cattle $cattle)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'age'       => 'required|integer|min:0',
            'weight_kg' => 'required|numeric|min:0',
            'breed'     => 'required|string|max:255',
            'gender'    => 'required|in:male,female',
        ]);

        $cattle->update($request->only(['name', 'age', 'weight_kg', 'breed', 'gender']));

        return redirect()->route('cattle.index')->with('success', 'Cattle updated successfully!');
    }

    public function destroy(Cattle $cattle)
    {
        $cattle->delete();
        return redirect()->route('cattle.index')->with('success', 'Cattle record deleted.');
    }
}