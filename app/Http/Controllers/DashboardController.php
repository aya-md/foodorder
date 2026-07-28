<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $business = Auth::user()?->business;

        $categoryCount = Category::count();
        $itemCount = Item::count();

        return view('dashboard', compact('business', 'categoryCount', 'itemCount'));
    }
}
