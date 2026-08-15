<?php
// app/Http/Controllers/WorkersController.php

namespace App\Http\Controllers;

use App\Models\Workers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WorkersController extends Controller
{
    public function workers()
    {
        $workers = Workers::all();
        $totalSalaries = $workers->sum('salary');
        $newHires = $workers->filter(fn($w) => $w->employment_date >= now()->subMonth())->count();
        $pendingTasks = 0;

        return view('dashboard.workers', compact('workers', 'totalSalaries', 'newHires', 'pendingTasks'));
    }

    public function create() { return view('workers.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'salary'          => 'required|numeric|min:0',
            'email'           => 'required|email|unique:workers,email',
            'password'        => 'required|string|min:8',
            'employment_date' => 'required|date',
            'phone'           => 'required|string|max:20',
            'position'        => 'required|string|max:255',
        ]);

        $data = $request->only(['name', 'salary', 'email', 'employment_date', 'phone', 'position']);
        $data['password'] = Hash::make($request->password);
        Workers::create($data);

        return redirect()->route('workers.index')->with('success', 'Worker added successfully!');
    }

    public function edit(Workers $worker)
    {
        return view('workers.edit', compact('worker'));
    }

    public function update(Request $request, Workers $worker)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'salary'          => 'required|numeric|min:0',
            'email'           => 'required|email|unique:workers,email,' . $worker->id,
            'employment_date' => 'required|date',
            'phone'           => 'required|string|max:20',
            'position'        => 'required|string|max:255',
            'password'        => 'nullable|string|min:8',
        ]);

        $data = $request->only(['name', 'salary', 'email', 'employment_date', 'phone', 'position']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $worker->update($data);

        return redirect()->route('workers.index')->with('success', 'Worker updated successfully!');
    }

    public function destroy(Workers $worker)
    {
        $worker->delete();
        return redirect()->route('workers.index')->with('success', 'Worker deleted.');
    }
}