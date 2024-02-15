<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

final class AuthController extends Controller
{
    final public function loginForm(): View
    {
        return view('login');
    }

    final public function login(): RedirectResponse
    {
        return Redirect::route('web.index');
    }

    final public function registrationForm(): RedirectResponse
    {
        return Redirect::route('web.index');
    }
}
