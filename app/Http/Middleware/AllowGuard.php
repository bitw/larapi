<?php

namespace App\Http\Middleware;

use App\Http\Responses\ForbiddenJsonResponse;
use App\Models\Customer;
use App\Models\Employee;
use Closure;

class AllowGuard
{
    public function handle($request, Closure $next, $guard)
    {
        /** @var Customer|Employee $user */
        $user = $request->user();

        $allowAccess = (bool)$user->getAllPermissions()
            ->where('guard_name', $guard)
            ->where('name', $guard)
            ->count();

        if ($allowAccess) {
            return $next($request);
        }

        return new ForbiddenJsonResponse();
    }
}
