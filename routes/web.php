<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ApiController::class, 'billing'])->name('billing');
Route::get('/pro', [ApiController::class, 'product'])->name('product');
Route::get('/print/{bill}', [ApiController::class, 'printInvoice'])->name('printInvoice');

Route::get('/mem', function () {
    return view('members');
});
Route::post('/add-product', [ApiController::class, 'prodAdd'])->name('prodAdd');
Route::post('/update-stock', [ApiController::class, 'updStock'])->name('updStock');
Route::post('/gen-invoice', [ApiController::class, 'genInvoice'])->name('genInvoice');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
