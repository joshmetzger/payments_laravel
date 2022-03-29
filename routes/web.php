<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/payments/pay', [App\Http\Controllers\PaymentController::class, 'pay'])->name('pay');
Route::get('/payments/approval', [App\Http\Controllers\PaymentController::class, 'approval'])->name('approval');
Route::get('/payments/cancelled', [App\Http\Controllers\PaymentController::class, 'cancelled'])->name('cancelled');

Route::prefix('subscribe')->group(function () {
    Route::get('/', [App\Http\Controllers\SubscriptionController::class, 'show'])->name('subscribe.show');
    Route::post('/', [App\Http\Controllers\SubscriptionController::class, 'store'])->name('subscribe.store');
    Route::get('/approvel', [App\Http\Controllers\SubscriptionController::class, 'store'])->name('subscribe.approval');
    Route::get('/cancelled', [App\Http\Controllers\SubscriptionController::class, 'store'])->name('subscribe.cancelled');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

