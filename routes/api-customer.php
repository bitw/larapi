<?php

use App\Http\Controllers\Api\Customer\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    'role:customer',
])->prefix('/v1')
    ->group(static function () {
        Route::get('/user', [UserController::class, 'user']);
    });
