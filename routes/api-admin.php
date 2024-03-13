<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'role:admin',
])->prefix('/v1')
    ->group(static function () {
        Route::get('/user', function (Request $request) {
            return new JsonResponse($request->user());
        });
    });
