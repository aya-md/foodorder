<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $business = $user?->business;

        $categoryCount = Category::count();
        $itemCount = Item::count();
        $activeOrderCount = Order::whereNotIn('status', ['completed', 'cancelled'])->count();

        return view('dashboard', compact('user', 'business', 'categoryCount', 'itemCount', 'activeOrderCount'));
    }
}
