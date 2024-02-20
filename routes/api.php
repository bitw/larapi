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
        ->attempt($request->getCredentials(), true);

    return $auth
        ? new OkJsonResponse(['bearer_token' => $request->user($request->route('guard'))
            ->createToken('default')->plainTextToken])
        : new UnauthorizedJsonResponse(['error' => __('common.invalid_email_or_password')]);
})->where('guard', collect(GuardsEnum::cases())->map(fn (GuardsEnum $guard) => $guard->value)->implode('|'));

// Customer bearer token
// 1|G1jX7ETeTx4HJhtcUu8Ma7pjiM4tz6MrCUMION2vdc9ca733
