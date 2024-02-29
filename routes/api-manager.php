<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    'role:admin|manager',
])->prefix('/v1')
    ->group(static function () {
        Route::get('/user', function (Request $request) {
            return new JsonResponse($request->user());
        });
    });
