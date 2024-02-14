<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

final class HomeController extends Controller
{
    public function index(): View
    {
        return view('index');
    }
}
