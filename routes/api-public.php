<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Public\RegistrationController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')
    ->group(function () {
        Route::post('/registration', [RegistrationController::class, 'registration'])
            ->name('api-public.registration');

        Route::get('/asd', function () {
            return new Response(phpinfo());
        });
    });