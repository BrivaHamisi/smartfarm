<?php
// app/Http/Controllers/CropController.php

namespace App\Http\Controllers;

use App\Models\CropField;
use App\Models\CropInput;
use App\Models\CropHarvest;
use Illuminate\Http\Request;

class CropController extends Controller
{
    public function index()
    {
        $fields = CropField::with(['inputs', 'harvests'])->get();
        $totalAcreage = $fields->sum('acreage');
        $totalHarvest = CropHarvest::sum('quantity_harvested');
        $recentHarvests = CropHarvest::with('field')->latest('date')->take(10)->get();

        return view('dashboard.crops', compact('fields', 'totalAcreage', 'totalHarvest', 'recentHarvests'));
    }

    // ── Fields ──────────────────────────────────────────
    public function createField() { return view('crops.fields.create'); }

    public function storeField(Request $request)
    {
        $request->validate([
            'field_name'    => 'required|string|max:255',
            'crop_planted'  => 'required|string|max:255',
            'acreage'       => 'required|numeric|min:0',
            'planting_date' => 'required|date',
        ]);

        CropField::create($request->only(['field_name', 'crop_planted', 'acreage', 'planting_date']));

        return redirect()->route('crops.index')->with('success', 'Field added!');
    }

    public function editField(CropField $field) { return view('crops.fields.edit', compact('field')); }

    public function updateField(Request $request, CropField $field)
    {
        $request->validate([
            'field_name'    => 'required|string|max:255',
            'crop_planted'  => 'required|string|max:255',
            'acreage'       => 'required|numeric|min:0',
            'planting_date' => 'required|date',
        ]);

        $field->update($request->only(['field_name', 'crop_planted', 'acreage', 'planting_date']));

        return redirect()->route('crops.index')->with('success', 'Field updated!');
    }

    public function destroyField(CropField $field)
    {
        $field->delete(); // cascades to inputs & harvests
        return redirect()->route('crops.index')->with('success', 'Field deleted.');
    }

    // ── Fertilizer / Pesticide Inputs ───────────────────
    public function createInput()
    {
        $fields = CropField::all();
        return view('crops.inputs.create', compact('fields'));
    }

    public function storeInput(Request $request)
    {
        $request->validate([
            'crop_field_id' => 'required|exists:crop_fields,id',
            'date'          => 'required|date',
            'type'          => 'required|in:fertilizer,pesticide,herbicide,other',
            'brand_name'    => 'required|string|max:255',
            'quantity'      => 'required|numeric|min:0',
            'unit'          => 'required|string|max:50',
        ]);

        CropInput::create($request->only(['crop_field_id', 'date', 'type', 'brand_name', 'quantity', 'unit']));

        return redirect()->route('crops.index')->with('success', 'Input record added!');
    }

    public function editInput(CropInput $input)
    {
        $fields = CropField::all();
        return view('crops.inputs.edit', compact('input', 'fields'));
    }

    public function updateInput(Request $request, CropInput $input)
    {
        $request->validate([
            'crop_field_id' => 'required|exists:crop_fields,id',
            'date'          => 'required|date',
            'type'          => 'required|in:fertilizer,pesticide,herbicide,other',
            'brand_name'    => 'required|string|max:255',
            'quantity'      => 'required|numeric|min:0',
            'unit'          => 'required|string|max:50',
        ]);

        $input->update($request->only(['crop_field_id', 'date', 'type', 'brand_name', 'quantity', 'unit']));

        return redirect()->route('crops.index')->with('success', 'Input record updated!');
    }

    public function destroyInput(CropInput $input)
    {
        $input->delete();
        return redirect()->route('crops.index')->with('success', 'Input record deleted.');
    }

    // ── Harvest Records ──────────────────────────────────
    public function createHarvest()
    {
        $fields = CropField::all();
        return view('crops.harvests.create', compact('fields'));
    }

    public function storeHarvest(Request $request)
    {
        $request->validate([
            'crop_field_id'      => 'required|exists:crop_fields,id',
            'date'               => 'required|date',
            'crop'               => 'required|string|max:255',
            'quantity_harvested' => 'required|numeric|min:0',
            'unit'               => 'required|string|max:50',
        ]);

        CropHarvest::create($request->only(['crop_field_id', 'date', 'crop', 'quantity_harvested', 'unit']));

        return redirect()->route('crops.index')->with('success', 'Harvest record added!');
    }

    public function editHarvest(CropHarvest $harvest)
    {
        $fields = CropField::all();
        return view('crops.harvests.edit', compact('harvest', 'fields'));
    }

    public function updateHarvest(Request $request, CropHarvest $harvest)
    {
        $request->validate([
            'crop_field_id'      => 'required|exists:crop_fields,id',
            'date'               => 'required|date',
            'crop'               => 'required|string|max:255',
            'quantity_harvested' => 'required|numeric|min:0',
            'unit'               => 'required|string|max:50',
        ]);

        $harvest->update($request->only(['crop_field_id', 'date', 'crop', 'quantity_harvested', 'unit']));

        return redirect()->route('crops.index')->with('success', 'Harvest record updated!');
    }

    public function destroyHarvest(CropHarvest $harvest)
    {
        $harvest->delete();
        return redirect()->route('crops.index')->with('success', 'Harvest record deleted.');
    }
}