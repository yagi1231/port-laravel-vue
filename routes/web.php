<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReservationController;
use App\Models\Reservation;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/analysis', [AnalysisController::class, 'index'])->name('analysis');

    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/purchases/{id}', [PurchaseController::class, 'show'])->name('purchases.show');

    Route::get('/', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/aggregate', [ReservationController::class, 'aggregate'])->name('reservations.aggregate');
    Route::resource('reservations', ReservationController::class);

    Route::resource('customers', CustomerController::class);

    Route::resource('items', ItemController::class);
});

require __DIR__ . '/auth.php';
