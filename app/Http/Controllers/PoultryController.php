<?php
// app/Http/Controllers/PoultryController.php

namespace App\Http\Controllers;

use App\Models\Poultry;
use Illuminate\Http\Request;

class PoultryController extends Controller
{
    public function poultry()
    {
        $poultry = Poultry::latest('date')->get();
        $totalChickens = $poultry->first()->chicken_count ?? 0;
        $eggsToday = $poultry->filter(fn($p) => $p->date->isToday())->sum('eggs_produced');
        $eggsSold = $poultry->filter(fn($p) => $p->date->isToday())->sum('eggs_sold');
        $mortalities = $poultry->filter(fn($p) => $p->date->isToday())->sum('mortalities');

        return view('dashboard.poultry', compact('poultry', 'totalChickens', 'eggsToday', 'eggsSold', 'mortalities'));
    }

    public function create() { return view('poultry.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'date'          => 'required|date',
            'chicken_count' => 'required|integer|min:0',
            'mortalities'   => 'required|integer|min:0',
            'eggs_produced' => 'required|integer|min:0',
            'eggs_sold'     => 'required|integer|min:0',
        ]);

        Poultry::create($request->only(['date', 'chicken_count', 'mortalities', 'eggs_produced', 'eggs_sold']));

        return redirect()->route('poultry.index')->with('success', 'Poultry record added successfully!');
    }

    public function edit(Poultry $poultry)
    {
        return view('poultry.edit', compact('poultry'));
    }

    public function update(Request $request, Poultry $poultry)
    {
        $request->validate([
            'date'          => 'required|date',
            'chicken_count' => 'required|integer|min:0',
            'mortalities'   => 'required|integer|min:0',
            'eggs_produced' => 'required|integer|min:0',
            'eggs_sold'     => 'required|integer|min:0',
        ]);

        $poultry->update($request->only(['date', 'chicken_count', 'mortalities', 'eggs_produced', 'eggs_sold']));

        return redirect()->route('poultry.index')->with('success', 'Poultry record updated!');
    }

    public function destroy(Poultry $poultry)
    {
        $poultry->delete();
        return redirect()->route('poultry.index')->with('success', 'Poultry record deleted.');
    }
}