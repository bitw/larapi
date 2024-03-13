<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Public;

use App\Exceptions\UserCreateException;
use App\Http\Requests\Api\Public\RegistrationRequest;
use App\Http\Responses\CreatedJsonResponse;
use App\Http\Responses\UnprocessableEntityJsonResponse;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegistrationController
{
    public function registration(
        RegistrationRequest $request,
        UserService $userService,
    ): JsonResponse {
        try {
            $userService->create((array)$request->getRegistrationDTO());
        } catch (UserCreateException $e) {
            return new UnprocessableEntityJsonResponse([
                'message' => __($e->getMessage())
            ]);
        }

        return new CreatedJsonResponse();
    }

    public function confirmEmail(Request $request)
    {
        //if($request)
    }
}
