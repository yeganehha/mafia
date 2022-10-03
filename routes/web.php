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

Route::get('/test', function () {
    $patternValues = [
        "verification-code" => "121212",
    ];

    try {
        $bulkID = IPPanel::sendPattern(
            "juhemz41m6yw3n7",    // pattern code
            "+983000505",      // originator
            "989375074371",  // recipient
            $patternValues,  // pattern values
        );
    } catch (Error $e) { // ippanel error
        var_dump($e->unwrap()); // get real content of error
        echo $e->getCode();

        // error codes checking
        if ($e->code() == ResponseCodes::ErrUnprocessableEntity) {
            echo "Unprocessable entity";
        }
    } catch (Exception $e) { // http error
        var_dump($e->getMessage()); // get stringified error
        echo $e->getCode();
    }
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::as('auth.')->prefix('Auth/')->middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('showLogin');
    Route::post('Login', [AuthController::class, 'login'])->name('login');
    Route::get('verify', [AuthController::class, 'showVerifyForm'])->name('showVerify');
    Route::post('verify', [AuthController::class, 'verify'])->name('verify');
});
Route::post('Auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
