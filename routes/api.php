<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Room\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::as('auth.')->prefix('Auth/')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('verify', [AuthController::class, 'verify']);
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:api');
});

Route::as('profile.')->prefix('profile/')->group(function () {
    Route::get('/', [ProfileController::class, 'profile'])->middleware('auth:api');
});


Route::as('rooms.')->prefix('room/')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::post('create/public', [RoomController::class, 'createPublic']);
        Route::post('create/private', [RoomController::class, 'createPrivate']);
        Route::get('{link}/join', [RoomController::class, 'joinRoom']);
        Route::post('{link}/password', [RoomController::class, 'checkRoomPass'])->name('checkRoomPass');
    });
    Route::get('all', [RoomController::class, 'all']);
});

Route::as('order.')->prefix('order/')->group(function () {
    Route::middleware(['auth:api'])->group(function () {
        Route::post('buyCoin', [OrderController::class, 'buyCoin']);
    });

    Route::get('repay/{uuid}', [OrderController::class, 'repay'])->name('repay');
    Route::get('callback/{uuid}', [OrderController::class, 'callback'])->name('callback');
});
