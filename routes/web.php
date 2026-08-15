
<?php

use App\Http\Controllers\CalvesController;
use App\Http\Controllers\CattleController;
use App\Http\Controllers\CropController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DorperController;
use App\Http\Controllers\FinancesController;
use App\Http\Controllers\InseminationController;
use App\Http\Controllers\MilkRecordController;
use App\Http\Controllers\PoultryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RabbitController;
use App\Http\Controllers\WorkersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // // ── Profile ───────────────────────────────────────────
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ── Cattle ───────────────────────────────────────────
    Route::get('/cattle',               [CattleController::class, 'index'])->name('cattle.index');
    Route::get('/cattle/create',        [CattleController::class, 'create'])->name('cattle.create');
    Route::post('/cattle',              [CattleController::class, 'store'])->name('cattle.store');
    Route::get('/cattle/{cattle}/edit', [CattleController::class, 'edit'])->name('cattle.edit');
    Route::put('/cattle/{cattle}',      [CattleController::class, 'update'])->name('cattle.update');
    Route::delete('/cattle/{cattle}',   [CattleController::class, 'destroy'])->name('cattle.destroy');

    // ── Calves ───────────────────────────────────────────
    Route::get('/calves',             [CalvesController::class, 'calves'])->name('calves.index');
    Route::get('/calves/create',      [CalvesController::class, 'create'])->name('calves.create');
    Route::post('/calves',            [CalvesController::class, 'store'])->name('calves.store');
    Route::get('/calves/{calf}/edit', [CalvesController::class, 'edit'])->name('calves.edit');
    Route::put('/calves/{calf}',      [CalvesController::class, 'update'])->name('calves.update');
    Route::delete('/calves/{calf}',   [CalvesController::class, 'destroy'])->name('calves.destroy');

    // ── Milk Records ─────────────────────────────────────
    Route::get('/milk-records',        [MilkRecordController::class, 'index'])->name('cattle.milk-records.index');
    Route::get('/milk-records/create', [MilkRecordController::class, 'create'])->name('cattle.milk-records.create');
    Route::post('/milk-records',       [MilkRecordController::class, 'store'])->name('cattle.milk-records.store');

    // ── Poultry ──────────────────────────────────────────
    Route::get('/poultry',                  [PoultryController::class, 'poultry'])->name('poultry.index');
    Route::get('/poultry/create',           [PoultryController::class, 'create'])->name('poultry.create');
    Route::post('/poultry',                 [PoultryController::class, 'store'])->name('poultry.store');
    Route::get('/poultry/{poultry}/edit',   [PoultryController::class, 'edit'])->name('poultry.edit');
    Route::put('/poultry/{poultry}',        [PoultryController::class, 'update'])->name('poultry.update');
    Route::delete('/poultry/{poultry}',     [PoultryController::class, 'destroy'])->name('poultry.destroy');

    // ── Finances ─────────────────────────────────────────
    Route::get('/finances',                   [FinancesController::class, 'finances'])->name('finances.index');
    Route::get('/finances/create',            [FinancesController::class, 'create'])->name('finances.create');
    Route::post('/finances',                  [FinancesController::class, 'store'])->name('finances.store');
    Route::get('/finances/{finances}/edit',   [FinancesController::class, 'edit'])->name('finances.edit');
    Route::put('/finances/{finances}',        [FinancesController::class, 'update'])->name('finances.update');
    Route::delete('/finances/{finances}',     [FinancesController::class, 'destroy'])->name('finances.destroy');

    // ── Workers ──────────────────────────────────────────
    Route::get('/workers',                [WorkersController::class, 'workers'])->name('workers.index');
    Route::get('/workers/create',         [WorkersController::class, 'create'])->name('workers.create');
    Route::post('/workers',               [WorkersController::class, 'store'])->name('workers.store');
    Route::get('/workers/{worker}/edit',  [WorkersController::class, 'edit'])->name('workers.edit');
    Route::put('/workers/{worker}',       [WorkersController::class, 'update'])->name('workers.update');
    Route::delete('/workers/{worker}',    [WorkersController::class, 'destroy'])->name('workers.destroy');

    // ── Dorper Farming ───────────────────────────────────
    Route::get('/dorper',                            [DorperController::class, 'index'])->name('dorper.index');
    Route::get('/dorper/animals/create',             [DorperController::class, 'createAnimal'])->name('dorper.animals.create');
    Route::post('/dorper/animals',                   [DorperController::class, 'storeAnimal'])->name('dorper.animals.store');
    Route::get('/dorper/animals/{animal}/edit',      [DorperController::class, 'editAnimal'])->name('dorper.animals.edit');
    Route::put('/dorper/animals/{animal}',           [DorperController::class, 'updateAnimal'])->name('dorper.animals.update');
    Route::delete('/dorper/animals/{animal}',        [DorperController::class, 'destroyAnimal'])->name('dorper.animals.destroy');
    Route::get('/dorper/breeding/create',            [DorperController::class, 'createBreeding'])->name('dorper.breeding.create');
    Route::post('/dorper/breeding',                  [DorperController::class, 'storeBreeding'])->name('dorper.breeding.store');
    Route::get('/dorper/breeding/{breeding}/edit',   [DorperController::class, 'editBreeding'])->name('dorper.breeding.edit');
    Route::put('/dorper/breeding/{breeding}',        [DorperController::class, 'updateBreeding'])->name('dorper.breeding.update');
    Route::delete('/dorper/breeding/{breeding}',     [DorperController::class, 'destroyBreeding'])->name('dorper.breeding.destroy');
    Route::get('/dorper/financials',                 [DorperController::class, 'financials'])->name('dorper.financials');

    // ── Crop Production ──────────────────────────────────
    Route::get('/crops',                         [CropController::class, 'index'])->name('crops.index');
    Route::get('/crops/fields/create',           [CropController::class, 'createField'])->name('crops.fields.create');
    Route::post('/crops/fields',                 [CropController::class, 'storeField'])->name('crops.fields.store');
    Route::get('/crops/fields/{field}/edit',     [CropController::class, 'editField'])->name('crops.fields.edit');
    Route::put('/crops/fields/{field}',          [CropController::class, 'updateField'])->name('crops.fields.update');
    Route::delete('/crops/fields/{field}',       [CropController::class, 'destroyField'])->name('crops.fields.destroy');
    Route::get('/crops/inputs/create',           [CropController::class, 'createInput'])->name('crops.inputs.create');
    Route::post('/crops/inputs',                 [CropController::class, 'storeInput'])->name('crops.inputs.store');
    Route::get('/crops/inputs/{input}/edit',     [CropController::class, 'editInput'])->name('crops.inputs.edit');
    Route::put('/crops/inputs/{input}',          [CropController::class, 'updateInput'])->name('crops.inputs.update');
    Route::delete('/crops/inputs/{input}',       [CropController::class, 'destroyInput'])->name('crops.inputs.destroy');
    Route::get('/crops/harvests/create',         [CropController::class, 'createHarvest'])->name('crops.harvests.create');
    Route::post('/crops/harvests',               [CropController::class, 'storeHarvest'])->name('crops.harvests.store');
    Route::get('/crops/harvests/{harvest}/edit', [CropController::class, 'editHarvest'])->name('crops.harvests.edit');
    Route::put('/crops/harvests/{harvest}',      [CropController::class, 'updateHarvest'])->name('crops.harvests.update');
    Route::delete('/crops/harvests/{harvest}',   [CropController::class, 'destroyHarvest'])->name('crops.harvests.destroy');

    // ── Rabbit Production ────────────────────────────────
    Route::get('/rabbits',                            [RabbitController::class, 'index'])->name('rabbits.index');
    Route::get('/rabbits/create',                     [RabbitController::class, 'createRabbit'])->name('rabbits.create');
    Route::post('/rabbits',                           [RabbitController::class, 'storeRabbit'])->name('rabbits.store');
    Route::get('/rabbits/{rabbit}/edit',              [RabbitController::class, 'editRabbit'])->name('rabbits.edit');
    Route::put('/rabbits/{rabbit}',                   [RabbitController::class, 'updateRabbit'])->name('rabbits.update');
    Route::delete('/rabbits/{rabbit}',                [RabbitController::class, 'destroyRabbit'])->name('rabbits.destroy');
    Route::get('/rabbits/breeding/create',            [RabbitController::class, 'createBreeding'])->name('rabbits.breeding.create');
    Route::post('/rabbits/breeding',                  [RabbitController::class, 'storeBreeding'])->name('rabbits.breeding.store');
    Route::get('/rabbits/breeding/{breeding}/edit',   [RabbitController::class, 'editBreeding'])->name('rabbits.breeding.edit');
    Route::put('/rabbits/breeding/{breeding}',        [RabbitController::class, 'updateBreeding'])->name('rabbits.breeding.update');
    Route::delete('/rabbits/breeding/{breeding}',     [RabbitController::class, 'destroyBreeding'])->name('rabbits.breeding.destroy');

    // Milk Records
    Route::get('/milk-records',                    [MilkRecordController::class, 'index'])->name('cattle.milk-records.index');
    Route::get('/milk-records/create',             [MilkRecordController::class, 'create'])->name('cattle.milk-records.create');
    Route::post('/milk-records',                   [MilkRecordController::class, 'store'])->name('cattle.milk-records.store');
    Route::get('/milk-records/{milkRecord}/edit',  [MilkRecordController::class, 'edit'])->name('cattle.milk-records.edit');
    Route::put('/milk-records/{milkRecord}',       [MilkRecordController::class, 'update'])->name('cattle.milk-records.update');
    Route::delete('/milk-records/{milkRecord}',    [MilkRecordController::class, 'destroy'])->name('cattle.milk-records.destroy');

    // Inseminations
    Route::get('/inseminations',                       [InseminationController::class, 'index'])->name('inseminations.index');
    Route::get('/inseminations/create',                [InseminationController::class, 'create'])->name('inseminations.create');
    Route::post('/inseminations',                      [InseminationController::class, 'store'])->name('inseminations.store');
    Route::get('/inseminations/{insemination}/edit',   [InseminationController::class, 'edit'])->name('inseminations.edit');
    Route::put('/inseminations/{insemination}',        [InseminationController::class, 'update'])->name('inseminations.update');
    Route::delete('/inseminations/{insemination}',     [InseminationController::class, 'destroy'])->name('inseminations.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
