<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $businesses = Business::where('status', 'approved')
            ->where('is_open', true)
            ->orderBy('name')
            ->get();

        return view('home', compact('businesses'));
    }
}
