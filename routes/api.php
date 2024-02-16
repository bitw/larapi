<?php

use App\Enums\GuardsEnum;
use App\Http\Requests\Web\LoginRequest;
use App\Http\Responses\OkJsonResponse;
use App\Http\Responses\UnauthorizedJsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/{guard}/login', function (LoginRequest $request) {
    $auth = Auth::guard($request->route('guard'))
        ->attempt($request->getCredentials());

    return $auth
        ? new OkJsonResponse(['bearer_token' => $request->user($request->route('guard'))
            ->createToken('default')->plainTextToken])
        : new UnauthorizedJsonResponse(['error' => __('common.invalid_email_or_password')]);
})->where('guard', collect(GuardsEnum::cases())->map(fn (GuardsEnum $guard) => $guard->value)->implode('|'));

// 6|Xp8zEZS3Wpnd7JJHlninrBuM257d3pRmYPSJM3Zgfa2d3137
