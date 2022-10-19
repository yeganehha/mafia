<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Room\RoomController;
use Illuminate\Support\Facades\Route;
use SmartRaya\IPPanelLaravel\Errors\ResponseCodes;
use SmartRaya\IPPanelLaravel\Facades\IPPanel;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::as('auth.')->prefix('Auth/')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('showLogin');
        Route::post('Login', [AuthController::class, 'login'])->name('login');
        Route::get('verify', [AuthController::class, 'showVerifyForm'])->name('showVerify');
        Route::post('verify', [AuthController::class, 'verify'])->name('verify');
    });
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::as('profile.')->prefix('profile/')->middleware('auth')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('home');

    Route::get('/active-room', [ProfileController::class, 'activeRoom'])->name('activeRoom');

    Route::get('/setting', [ProfileController::class, 'setting'])->name('setting');
    Route::post('/edit', [ProfileController::class, 'update'])->name('edit');
});

Route::as('rooms.')->prefix('r/')->middleware('auth')->group(function () {
    Route::get('create', [RoomController::class, 'createRoom'])->name('create');
    Route::post('create', [RoomController::class, 'storeRoom']);

    Route::get('{link}/join', [RoomController::class, 'joinRoom'])->name('join');
    Route::post('{link}/enter', [RoomController::class, 'enterRoom'])->name('enter');
    Route::post('{link}/delete', [RoomController::class, 'deleteRoom'])->name('delete');
    Route::post('{link}/exit', [RoomController::class, 'exitRoom'])->name('exit');

    Route::get('{link}/password', [RoomController::class, 'showPassForm'])->name('showPassForm');
    Route::post('{link}/password', [RoomController::class, 'checkRoomPass'])->name('checkRoomPass');

    Route::get('{id}/{link}', [RoomController::class, 'room'])->name('room');
});
