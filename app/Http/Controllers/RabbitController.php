<?php
// app/Http/Controllers/RabbitController.php

namespace App\Http\Controllers;

use App\Models\Rabbit;
use App\Models\RabbitBreedingRecord;
use Illuminate\Http\Request;

class RabbitController extends Controller
{
    public function index()
    {
        $rabbits = Rabbit::all();
        $does = $rabbits->where('gender', 'doe')->count();
        $bucks = $rabbits->where('gender', 'buck')->count();
        $breedingRecords = RabbitBreedingRecord::latest()->get();
        $upcomingKindlings = RabbitBreedingRecord::where('expected_kindling_date', '<=', now()->addDays(14))
            ->whereNull('litter_size')->count();

        return view('dashboard.rabbits', compact('rabbits', 'does', 'bucks', 'breedingRecords', 'upcomingKindlings'));
    }

    // ── Rabbit Identification ────────────────────────────
    public function createRabbit() { return view('rabbits.create'); }

    public function storeRabbit(Request $request)
    {
        $request->validate([
            'rabbit_id' => 'required|string|max:50|unique:rabbits,rabbit_id',
            'breed'     => 'required|string|max:255',
            'gender'    => 'required|in:doe,buck',
        ]);

        Rabbit::create($request->only(['rabbit_id', 'breed', 'gender']));

        return redirect()->route('rabbits.index')->with('success', 'Rabbit added!');
    }

    public function editRabbit(Rabbit $rabbit) { return view('rabbits.edit', compact('rabbit')); }

    public function updateRabbit(Request $request, Rabbit $rabbit)
    {
        $request->validate([
            'rabbit_id' => 'required|string|max:50|unique:rabbits,rabbit_id,' . $rabbit->id,
            'breed'     => 'required|string|max:255',
            'gender'    => 'required|in:doe,buck',
        ]);

        $rabbit->update($request->only(['rabbit_id', 'breed', 'gender']));

        return redirect()->route('rabbits.index')->with('success', 'Rabbit updated!');
    }

    public function destroyRabbit(Rabbit $rabbit)
    {
        $rabbit->delete();
        return redirect()->route('rabbits.index')->with('success', 'Rabbit deleted.');
    }

    // ── Breeding Records ─────────────────────────────────
    public function createBreeding()
    {
        $does = Rabbit::where('gender', 'doe')->get();
        $bucks = Rabbit::where('gender', 'buck')->get();
        return view('rabbits.breeding.create', compact('does', 'bucks'));
    }

    public function storeBreeding(Request $request)
    {
        $request->validate([
            'doe_id'      => 'required|string',
            'buck_id'     => 'required|string',
            'mating_date' => 'required|date',
        ]);

        $matingDate = \Carbon\Carbon::parse($request->mating_date);
        // Rabbit gestation ≈ 31 days
        $expectedKindlingDate = $matingDate->copy()->addDays(31);

        RabbitBreedingRecord::create([
            'doe_id'                  => $request->doe_id,
            'buck_id'                 => $request->buck_id,
            'mating_date'             => $matingDate,
            'expected_kindling_date'  => $expectedKindlingDate,
        ]);

        return redirect()->route('rabbits.index')->with('success', 'Breeding record added! Expected kindling: ' . $expectedKindlingDate->format('d M Y'));
    }

    public function editBreeding(RabbitBreedingRecord $breeding)
    {
        $does = Rabbit::where('gender', 'doe')->get();
        $bucks = Rabbit::where('gender', 'buck')->get();
        return view('rabbits.breeding.edit', compact('breeding', 'does', 'bucks'));
    }

    public function updateBreeding(Request $request, RabbitBreedingRecord $breeding)
    {
        $request->validate([
            'doe_id'       => 'required|string',
            'buck_id'      => 'required|string',
            'mating_date'  => 'required|date',
            'litter_size'  => 'nullable|integer|min:0',
        ]);

        $matingDate = \Carbon\Carbon::parse($request->mating_date);
        $breeding->update([
            'doe_id'                 => $request->doe_id,
            'buck_id'                => $request->buck_id,
            'mating_date'            => $matingDate,
            'expected_kindling_date' => $matingDate->copy()->addDays(31),
            'litter_size'            => $request->litter_size,
        ]);

        return redirect()->route('rabbits.index')->with('success', 'Breeding record updated!');
    }

    public function destroyBreeding(RabbitBreedingRecord $breeding)
    {
        $breeding->delete();
        return redirect()->route('rabbits.index')->with('success', 'Breeding record deleted.');
    }
}