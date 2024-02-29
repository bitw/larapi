<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Customer;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController
{
    public function user(Request $request): UserResource
    {
        return UserResource::make($request->user());
    }
}