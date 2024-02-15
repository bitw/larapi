<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('web.index');

Route::get('/login', [AuthController::class, 'loginForm'])
    ->name('web.login-form');

Route::post('/login', [AuthController::class, 'login'])
    ->name('web.login');

if (config('common.app_allow_web_registration')) {
    Route::get('/registration', [AuthController::class, 'registrationForm'])
        ->name('web.registration-form');
}
