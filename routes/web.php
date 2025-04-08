<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalvesController;
use App\Http\Controllers\CattleController;
use App\Http\Controllers\PoultryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkersController;
use App\Http\Controllers\FinancesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MilkRecordController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/cattle', [CattleController::class, 'cattle'])->name('cattle.index');
Route::get('/cattle/create', [CattleController::class, 'create'])->name('cattle.create');
Route::post('/cattle', [CattleController::class, 'store'])->name('cattle.store');

Route::get('/cattle/milk-record', [MilkRecordController::class, 'index'])->name('cattle.milk-records.index');
Route::get('/cattle/milk-record/create', [MilkRecordController::class, 'create'])->name('cattle.milk-records.create');
Route::post('/cattle/milk-record', [MilkRecordController::class, 'store'])->name('cattle.milk-records.store');

Route::get('/finances', [FinancesController::class, 'finances'])->name('finances.index');
Route::get('/finances/create', [FinancesController::class, 'create'])->name('finances.create');
Route::post('/finances', [FinancesController::class, 'store'])->name('finances.store');

Route::get('/poultry', [PoultryController::class, 'poultry'])->name('poultry.index');
Route::get('/poultry/create', [PoultryController::class, 'create'])->name('poultry.create'); // Show create form
Route::post('/poultry', [PoultryController::class, 'store'])->name('poultry.store');


Route::get('/workers', [WorkersController::class, 'workers'])->name('workers.index');
Route::get('/workers/create', [WorkersController::class, 'create'])->name('workers.create');
Route::post('/workers', [WorkersController::class, 'store'])->name('workers.store');


Route::get('/calves', [CalvesController::class, 'calves'])->name('calves.index');
Route::get('/calves/create', [CalvesController::class, 'create'])->name('calves.create');
Route::post('/calves', [CalvesController::class, 'store'])->name('calves.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('cattle', CattleController::class)
    ->only(['index', 'cattle'])
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
