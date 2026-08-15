<?php
// app/Http/Controllers/DorperController.php

namespace App\Http\Controllers;

use App\Models\DorperAnimal;
use App\Models\DorperBreedingRecord;
use App\Models\Finances;
use Illuminate\Http\Request;

class DorperController extends Controller
{
    // ── Animal Identification ──────────────────────────────
    public function index()
    {
        $animals = DorperAnimal::latest()->get();
        $breedingRecords = DorperBreedingRecord::latest()->get();
        $ewes = $animals->whereIn('gender', ['ewe', 'lamb'])->count();
        $rams = $animals->where('gender', 'ram')->count();
        $upcomingLambings = DorperBreedingRecord::where('expected_lambing_date', '<=', now()->addMonth())
            ->whereNull('lambing_date')->count();

        return view('dashboard.dorper', compact('animals', 'breedingRecords', 'ewes', 'rams', 'upcomingLambings'));
    }

    public function createAnimal() { return view('dorper.animals.create'); }

    public function storeAnimal(Request $request)
    {
        $request->validate([
            'tag_number'    => 'required|string|max:50|unique:dorper_animals,tag_number',
            'date_of_birth' => 'required|date',
            'breed_lineage' => 'required|string|max:255',
            'gender'        => 'required|in:ewe,ram,lamb',
            'weight_kg'     => 'required|numeric|min:0',
            'notes'         => 'nullable|string',
        ]);

        DorperAnimal::create($request->only(['tag_number', 'date_of_birth', 'breed_lineage', 'gender', 'weight_kg', 'notes']));

        return redirect()->route('dorper.index')->with('success', 'Animal record added!');
    }

    public function editAnimal(DorperAnimal $animal) { return view('dorper.animals.edit', compact('animal')); }

    public function updateAnimal(Request $request, DorperAnimal $animal)
    {
        $request->validate([
            'tag_number'    => 'required|string|max:50|unique:dorper_animals,tag_number,' . $animal->id,
            'date_of_birth' => 'required|date',
            'breed_lineage' => 'required|string|max:255',
            'gender'        => 'required|in:ewe,ram,lamb',
            'weight_kg'     => 'required|numeric|min:0',
            'notes'         => 'nullable|string',
        ]);

        $animal->update($request->only(['tag_number', 'date_of_birth', 'breed_lineage', 'gender', 'weight_kg', 'notes']));

        return redirect()->route('dorper.index')->with('success', 'Animal record updated!');
    }

    public function destroyAnimal(DorperAnimal $animal)
    {
        $animal->delete();
        return redirect()->route('dorper.index')->with('success', 'Animal record deleted.');
    }

    // ── Breeding Records ───────────────────────────────────
    public function createBreeding()
    {
        $ewes = DorperAnimal::whereIn('gender', ['ewe'])->get();
        $rams = DorperAnimal::where('gender', 'ram')->get();
        return view('dorper.breeding.create', compact('ewes', 'rams'));
    }

    public function storeBreeding(Request $request)
    {
        $request->validate([
            'ewe_tag'     => 'required|string',
            'ram_tag'     => 'required|string',
            'mating_date' => 'required|date',
            'remarks'     => 'nullable|string',
        ]);

        $matingDate = \Carbon\Carbon::parse($request->mating_date);
        // Dorper gestation ≈ 147 days
        $expectedLambingDate = $matingDate->copy()->addDays(147);

        DorperBreedingRecord::create([
            'ewe_tag'               => $request->ewe_tag,
            'ram_tag'               => $request->ram_tag,
            'mating_date'           => $matingDate,
            'expected_lambing_date' => $expectedLambingDate,
            'remarks'               => $request->remarks,
        ]);

        return redirect()->route('dorper.index')->with('success', 'Breeding record added! Expected lambing: ' . $expectedLambingDate->format('d M Y'));
    }

    public function editBreeding(DorperBreedingRecord $breeding)
    {
        $ewes = DorperAnimal::where('gender', 'ewe')->get();
        $rams = DorperAnimal::where('gender', 'ram')->get();
        return view('dorper.breeding.edit', compact('breeding', 'ewes', 'rams'));
    }

    public function updateBreeding(Request $request, DorperBreedingRecord $breeding)
    {
        $request->validate([
            'ewe_tag'       => 'required|string',
            'ram_tag'       => 'required|string',
            'mating_date'   => 'required|date',
            'lambing_date'  => 'nullable|date',
            'lambs_born'    => 'nullable|integer|min:0',
            'remarks'       => 'nullable|string',
        ]);

        $matingDate = \Carbon\Carbon::parse($request->mating_date);

        $breeding->update([
            'ewe_tag'               => $request->ewe_tag,
            'ram_tag'               => $request->ram_tag,
            'mating_date'           => $matingDate,
            'expected_lambing_date' => $matingDate->copy()->addDays(147),
            'lambing_date'          => $request->lambing_date,
            'lambs_born'            => $request->lambs_born,
            'remarks'               => $request->remarks,
        ]);

        return redirect()->route('dorper.index')->with('success', 'Breeding record updated!');
    }

    public function destroyBreeding(DorperBreedingRecord $breeding)
    {
        $breeding->delete();
        return redirect()->route('dorper.index')->with('success', 'Breeding record deleted.');
    }

    // ── Link to Finances ───────────────────────────────────
    public function financials()
    {
        $financials = Finances::where('category', 'dorper')->get();
        $income = $financials->where('type', 'income')->sum('amount');
        $expenses = $financials->where('type', 'expense')->sum('amount');
        return view('dorper.financials', compact('financials', 'income', 'expenses'));
    }
}