<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReservationController;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/reservations/aggregate', function () {
//     return Inertia::render('Reservation/Aggregate');
// })->middleware(['auth', 'verified'])->name('aggregate');

Route::get('/purchases', [ PurchaseController::class, 'index' ])->name('purchases.index');
Route::get('/purchases/{id}', [ PurchaseController::class, 'show' ])->name('purchases.show');

Route::get('/reservations/aggregate', [ ReservationController::class, 'aggregate' ])->name('reservations.aggregate');

Route::resource('customers', CustomerController::class)->middleware(['auth', 'verified']);

Route::resource('reservations', ReservationController::class)->middleware(['auth', 'verified']);

Route::resource('items', ItemController::class)->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
