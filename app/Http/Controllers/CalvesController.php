<?php
// app/Http/Controllers/CalvesController.php

namespace App\Http\Controllers;

use App\Models\Calf;
use App\Models\Cattle;
use Illuminate\Http\Request;

class CalvesController extends Controller
{
    public function calves()
    {
        $calves = Calf::with('cattle')->get();
        $newCalves = $calves->filter(fn($c) => $c->dob >= now()->subMonth())->count();
        $maleCalves = $calves->where('gender', 'male')->count();
        $femaleCalves = $calves->where('gender', 'female')->count();

        return view('dashboard.calves', compact('calves', 'newCalves', 'maleCalves', 'femaleCalves'));
    }

    public function create()
    {
        $cattle = Cattle::where('gender', 'female')->get();
        return view('calves.create', compact('cattle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cow_id'    => 'required|exists:cattle,id',
            'name'      => 'required|string|max:255',
            'dob'       => 'required|date',
            'weight_kg' => 'required|numeric|min:0',
            'breed'     => 'required|string|max:255',
            'gender'    => 'required|in:male,female',
        ]);

        Calf::create($request->only(['cow_id', 'name', 'dob', 'weight_kg', 'breed', 'gender']));

        return redirect()->route('calves.index')->with('success', 'Calf added successfully!');
    }

    public function edit(Calf $calf)
    {
        $cattle = Cattle::where('gender', 'female')->get();
        return view('calves.edit', compact('calf', 'cattle'));
    }

    public function update(Request $request, Calf $calf)
    {
        $request->validate([
            'cow_id'    => 'required|exists:cattle,id',
            'name'      => 'required|string|max:255',
            'dob'       => 'required|date',
            'weight_kg' => 'required|numeric|min:0',
            'breed'     => 'required|string|max:255',
            'gender'    => 'required|in:male,female',
        ]);

        $calf->update($request->only(['cow_id', 'name', 'dob', 'weight_kg', 'breed', 'gender']));

        return redirect()->route('calves.index')->with('success', 'Calf updated successfully!');
    }

    public function destroy(Calf $calf)
    {
        $calf->delete();
        return redirect()->route('calves.index')->with('success', 'Calf record deleted.');
    }
}