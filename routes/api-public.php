<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Public\TokenController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')
    ->group(function () {
        Route::post('/token/create', [TokenController::class, 'create'])
            ->name('api-public.token.create');
    });
