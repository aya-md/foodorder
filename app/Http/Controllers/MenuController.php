<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function show(Request $request, string $slug): View
    {
        $business = Business::where('slug', $slug)->firstOrFail();

        if ($business->status !== 'approved') {
            return view('menu.unavailable', compact('business'));
        }

        $table = $request->query('table');
        if ($table) {
            session(['dine_in_table' => $table, 'dine_in_business_id' => $business->id]);
        }

        $categories = $business->categories()
            ->with(['items' => function ($query) {
                $query->where('available', true);
            }])
            ->orderBy('position')
            ->get();

        $cart = session('cart', ['business_id' => null, 'items' => []]);
        $cartCount = $cart['business_id'] === $business->id
            ? array_sum(array_column($cart['items'], 'quantity'))
            : 0;

        return view('menu.show', compact('business', 'categories', 'cartCount'));
    }
}
