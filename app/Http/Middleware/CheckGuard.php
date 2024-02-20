<?php

namespace App\Http\Middleware;

use App\Enums\GuardsEnum;
use App\Http\Responses\ForbiddenJsonResponse;
use App\Models\Customer;
use App\Models\Employee;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class CheckGuard
{
    public function handle($request, Closure $next, $guard)
    {
        /** @var Customer|Employee $user */
        $user = $request->user();

        /** @var Collection<Role> $roles */
        $roles = $user->roles;

        $userGuards = $roles->pluck('guard_name')->toArray();

        if (
            in_array(GuardsEnum::GUARD_API_ADMIN->value, $userGuards)
            || in_array($guard, $userGuards)
        ) {
            return $next($request);
        }

        return new ForbiddenJsonResponse();
    }
}
