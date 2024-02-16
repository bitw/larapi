<?php

namespace App\Http\Controllers\Web;

use App\Enums\GuardsEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

final class AuthController extends Controller
{
    final public function loginForm(Request $request): View
    {
        return view('login');
    }

    final public function login(LoginRequest $request): RedirectResponse
    {
        $auth = Auth::guard(GuardsEnum::GUARD_API_ADMIN->value)->attempt($request->getCredentials(), true);

        if ($auth) {
            $request->session()->regenerate();
            return response()->redirectToIntended();
        } else {
            return \redirect()->back()->withErrors(['message' => __('common.invalid_email_or_password')]);
        }
    }

    final public function registrationForm(): RedirectResponse
    {
        return Redirect::route('web.index');
    }
}
