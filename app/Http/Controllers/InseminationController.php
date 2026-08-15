<?php
// app/Http/Controllers/InseminationController.php

namespace App\Http\Controllers;

use App\Models\Cattle;
use App\Models\Insemination;
use Illuminate\Http\Request;

class InseminationController extends Controller
{
    public function index()
    {
        $inseminations = Insemination::with('cow')->latest('date')->get();
        $pending = $inseminations->whereNull('successful')->count();
        $successful = $inseminations->where('successful', true)->count();
        $failed = $inseminations->where('successful', false)->count();

        return view('cattle.inseminations.index', compact('inseminations', 'pending', 'successful', 'failed'));
    }

    public function create()
    {
        $cattle = Cattle::where('gender', 'female')->get();
        return view('cattle.inseminations.create', compact('cattle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cow_id'       => 'required|exists:cattle,id',
            'date'         => 'required|date',
            'bull_number'  => 'required|string|max:100',
            'successful'   => 'nullable|boolean',
            'expected_dob' => 'nullable|date|after:date',
        ]);

        Insemination::create($request->only(['cow_id', 'date', 'bull_number', 'successful', 'expected_dob']));

        return redirect()->route('inseminations.index')->with('success', 'Insemination record added!');
    }

    public function edit(Insemination $insemination)
    {
        $cattle = Cattle::where('gender', 'female')->get();
        return view('cattle.inseminations.edit', compact('insemination', 'cattle'));
    }

    public function update(Request $request, Insemination $insemination)
    {
        $request->validate([
            'cow_id'       => 'required|exists:cattle,id',
            'date'         => 'required|date',
            'bull_number'  => 'required|string|max:100',
            'successful'   => 'nullable|boolean',
            'expected_dob' => 'nullable|date',
        ]);

        $insemination->update($request->only(['cow_id', 'date', 'bull_number', 'successful', 'expected_dob']));

        return redirect()->route('inseminations.index')->with('success', 'Insemination record updated!');
    }

    public function destroy(Insemination $insemination)
    {
        $insemination->delete();
        return redirect()->route('inseminations.index')->with('success', 'Record deleted.');
    }
}