<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

final class AuthController extends Controller
{
    final public function getLogin(): View
    {
        return view('login');
    }
}
