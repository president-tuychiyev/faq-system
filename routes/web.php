<?php

use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', [FaqController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('faq')->name('faq.')->group(function () {
        Route::post('store', [FaqController::class, 'store'])->name('store');
        Route::post('update', [FaqController::class, 'update'])->name('update');
        Route::post('destroy', [FaqController::class, 'destroy'])->name('destroy');
    });

    Route::post('idn/update', [FaqController::class, 'idnUpdate'])->name('idn.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
