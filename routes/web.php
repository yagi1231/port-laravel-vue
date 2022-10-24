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

Route::get('/', [ ReservationController::class, 'index' ])->middleware(['auth', 'verified'])->name('reservations.index');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/analysis', [ AnalysisController::class, 'index' ])->name('analysis');
Route::get('/purchases', [ PurchaseController::class, 'index' ])->name('purchases.index');
Route::get('/purchases/{id}', [ PurchaseController::class, 'show' ])->name('purchases.show');

Route::get('/reservations/aggregate', [ ReservationController::class, 'aggregate' ])->name('reservations.aggregate');

Route::resource('customers', CustomerController::class)->middleware(['auth', 'verified']);

// Route::prefix('reservations')->group(function(){
//     Route::get('/', [ ReservationController::class, 'index'])->name('reservation.index');
//     Route::post('/', [ ReservationController::class, 'index'])->name('reservation.index');
//     Route::get('/{reservation}', [ ReservationController::class, 'show'])->name('reservation.show');
//     Route::get('/create', [ ReservationController::class, 'create'])->name('reservation.create');
//     Route::post('/create', [ ReservationController::class, 'create'])->name('reservation.create');
//     Route::post('/store', [ ReservationController::class, 'store'])->name('reservation.store');
//     Route::get('/edit/{reservation}', [ ReservationController::class, 'edit'])->name('reservation.edit');
//     Route::get('/update/{reservation}', [ ReservationController::class, 'update'])->name('reservation.update');
//     Route::post('/update/{reservation}', [ ReservationController::class, 'update'])->name('reservation.update');
//     Route::get('/delete/{reservation}', [ ReservationController::class, 'destroy'])->name('reservation.destroy ');
//   });

Route::resource('reservations', ReservationController::class)->middleware(['auth', 'verified']);

Route::resource('items', ItemController::class)->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';