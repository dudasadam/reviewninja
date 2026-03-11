<?php

namespace App\Http\Controllers;

use App\Models\Main;
use Illuminate\Contracts\View\View;

class MainController extends Controller
{
    public function index(): View
    {
        return view('main', [
            'page' => Main::homepage(),
        ]);
    }
}
