<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::post('users/activate/{user}', [UserController::class, 'activate'])->name('users.activate');
    Route::post('users/deactivate/{user}', [UserController::class, 'deactivate'])->name('users.deactivate');
    Route::resource('users', UserController::class)->except(['show', 'destroy']);

    Route::get('orders', [OrderController::class, 'index'])->name('orders');
    Route::get('transactions/{id}', [OrderController::class, 'transactions'])->name('transactions');

    Route::get('setting', [SettingController::class, 'index'])->name('setting');
    Route::post('setting', [SettingController::class, 'update']);
});
