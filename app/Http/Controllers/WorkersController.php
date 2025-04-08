<?php

namespace App\Http\Controllers;

use App\Models\Workers;
use Illuminate\Http\Request;

class WorkersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function workers()
    {
        $workers = Workers::all();
        $totalSalaries = $workers->sum('salary');
        $newHires = $workers->where('employment_date', '>=', now()->subMonth())->count();
        $pendingTasks = 0; // Add task logic if needed

        return view('dashboard.workers', compact('workers', 'totalSalaries', 'newHires', 'pendingTasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('workers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'email' => 'required|string|email|max:255|unique:workers,email',
            'password' => 'required|string|min:8',
            'employment_date' => 'required|date',
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:255',
        ]);

        Workers::create($request->all());

        return redirect()->route('workers.index')->with('success', 'Worker added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Workers $workers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workers $workers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workers $workers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workers $workers)
    {
        //
    }
}
