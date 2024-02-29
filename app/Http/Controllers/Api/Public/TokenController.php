<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Public;

use App\Enums\RolesEnum;
use App\Http\Requests\ApiPublic\TokenRequest;
use App\Http\Responses\OkJsonResponse;
use App\Http\Responses\UnprocessableEntityJsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TokenController
{
    public function create(TokenRequest $request): OkJsonResponse|UnprocessableEntityJsonResponse
    {
        $auth = Auth::attempt($request->getCredentials(), true);

        if (!$auth) {
            return new UnprocessableEntityJsonResponse(['error' => __('common.invalid_email_or_password')]);
        }
        /** @var User $user */
        $user = $request->user();

        $expiredAt = now()->addYear();
        $bearerToken = $user->createToken(
            RolesEnum::GUARD,
            expiresAt: $expiredAt
        )->plainTextToken;

        return new OkJsonResponse([
            'bearer_token' => $bearerToken,
            'expired_at' => $expiredAt
        ]);
    }
}
