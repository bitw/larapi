<?php

namespace App\Http\Middleware;

use App\Enums\GuardsEnum;
use App\Http\Responses\ForbiddenJsonResponse;
use App\Models\Customer;
use App\Models\Employee;
use Closure;

class CheckGuard
{
    public function handle($request, Closure $next, $guard)
    {
        /** @var Employee|Customer $user */
        $user = $request->user();

        $userGuards = ($user->roles->pluck('guard_name')->toArray());
        if (
            in_array(GuardsEnum::GUARD_API_ADMIN->value, $userGuards)
            || in_array($guard, $userGuards)
        ) {
            return $next($request);
        }

        return new ForbiddenJsonResponse();
    }
}
