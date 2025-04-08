<?php

use App\Http\Controllers\CattleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/cattle', [CattleController::class, 'cattle'])->name('cattle.index');
Route::get('/cattle/create', [CattleController::class, 'create'])->name('cattle.create');
Route::post('/cattle', [CattleController::class, 'store'])->name('cattle.store');

// Route::get('/finances', [FarmController::class, 'finances'])->name('finances.index');
// Route::get('/poultry', [FarmController::class, 'poultry'])->name('poultry.index');
// Route::get('/workers', [FarmController::class, 'workers'])->name('workers.index');
// Route::get('/calves', [FarmController::class, 'calves'])->name('calves.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('cattle', CattleController::class)
    ->only(['index', 'cattle'])
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
