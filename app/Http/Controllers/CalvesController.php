<?php

namespace App\Http\Controllers;

use App\Models\Calf;
use App\Models\Cattle;
use Illuminate\Http\Request;

class CalvesController extends Controller
{
    public function calves()
    {
        $calves = Calf::with('cattle')->get();
        $newCalves = $calves->where('dob', '>=', now()->subMonth())->count();
        $maleCalves = $calves->where('gender', 'male')->count();
        $femaleCalves = $calves->where('gender', 'female')->count();

        return view('dashboard.calves', compact('calves', 'newCalves', 'maleCalves', 'femaleCalves'));
    }

    public function create()
    {
        $cattle = Cattle::where('gender', 'female')->get(); // Only female cattle can be mothers
        return view('calves.create', compact('cattle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cow_id' => 'required|exists:cattle,id',
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'weight_kg' => 'required|numeric|min:0',
            'breed' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
        ]);

        Calf::create($request->all());

        return redirect()->route('calves.index')->with('success', 'Calf added successfully!');
    }
}
