<?php

namespace App\Http\Controllers;

use App\Models\Poultry;
use Illuminate\Http\Request;

class PoultryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function poultry()
    {
        $poultry = Poultry::all();
        $totalChickens = $poultry->last()->chicken_count ?? 0;
        $eggsToday = $poultry->where('date', today())->sum('eggs_produced');
        $eggsSold = $poultry->where('date', today())->sum('eggs_sold');
        $mortalities = $poultry->where('date', today())->sum('mortalities');

        return view('dashboard.poultry', compact('poultry', 'totalChickens', 'eggsToday', 'eggsSold', 'mortalities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('poultry.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'chicken_count' => 'required|integer|min:0',
            'mortalities' => 'required|integer|min:0',
            'eggs_produced' => 'required|integer|min:0',
            'eggs_sold' => 'required|integer|min:0',
        ]);

        Poultry::create($request->all());

        return redirect()->route('poultry.index')->with('success', 'Poultry record added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Poultry $poultry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Poultry $poultry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Poultry $poultry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Poultry $poultry)
    {
        //
    }
}
