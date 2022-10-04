<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
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
