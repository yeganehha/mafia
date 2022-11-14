<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\RoomController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::as('users.')->prefix('users/')->group(function () {
    Route::post('activate/{user}', [UserController::class, 'activate'])->name('activate');
    Route::post('deactivate/{user}', [UserController::class, 'deactivate'])->name('deactivate');
    Route::get('{userId}/history', [UserController::class, 'showRooms'])->name('history');
});
Route::resource('users', UserController::class)->except(['show', 'destroy']);

Route::get('orders', [OrderController::class, 'index'])->name('orders');
Route::get('transactions/{id}', [OrderController::class, 'transactions'])->name('transactions');

Route::get('setting', [SettingController::class, 'index'])->name('setting');
Route::post('setting', [SettingController::class, 'update']);


Route::as('rooms.')->prefix('rooms/')->group(function () {
    Route::get('{id}/details', [RoomController::class, 'showDetails'])->name('details');
});
Route::resource('rooms', RoomController::class)->only(['index', 'destroy']);

Route::resource('package', PackageController::class)->except('show');

