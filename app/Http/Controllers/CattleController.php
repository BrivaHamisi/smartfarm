<?php

namespace App\Http\Controllers;

use App\Models\Cattle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CattleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('dashboard.cattle');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cattle $cattle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cattle $cattle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cattle $cattle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cattle $cattle)
    {
        //
    }
}
