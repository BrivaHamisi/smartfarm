
<?php

use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// The authenticated dashboard and all farm-management modules (cattle, calves,
// milk records, inseminations, checkups, poultry, finances, workers, dorper,
// crops, rabbits) are managed through the Filament panel at /dashboard.

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pdf/invoice/{invoice}', [PdfController::class, 'invoice'])->name('pdf.invoice');
    Route::get('/pdf/farm-report', [PdfController::class, 'farmReport'])->name('pdf.farm-report');
});

require __DIR__.'/auth.php';
