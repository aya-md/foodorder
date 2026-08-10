<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function add(Request $request, Item $item): RedirectResponse
    {
        $cart = session('cart', ['business_id' => null, 'items' => []]);

        if ($cart['business_id'] !== $item->business_id) {
            $cart = ['business_id' => $item->business_id, 'items' => []];
        }

        $quantity = $cart['items'][$item->id]['quantity'] ?? 0;
        $cart['items'][$item->id] = ['quantity' => $quantity + 1];

        session(['cart' => $cart]);

        $newQuantity = $cart['items'][$item->id]['quantity'];

        return back()->with('status', "{$item->name} added to cart. You now have {$newQuantity} in your cart.");
    }

    public function decrease(Request $request, Item $item): RedirectResponse
    {
        $cart = session('cart', ['business_id' => null, 'items' => []]);

        if (! isset($cart['items'][$item->id])) {
            return back();
        }

        $quantity = $cart['items'][$item->id]['quantity'] - 1;

        if ($quantity <= 0) {
            unset($cart['items'][$item->id]);
            $message = "{$item->name} removed from cart.";
        } else {
            $cart['items'][$item->id]['quantity'] = $quantity;
            $message = "{$item->name} updated to {$quantity} in your cart.";
        }

        session(['cart' => $cart]);

        return back()->with('status', $message);
    }

    public function remove(Request $request, Item $item): RedirectResponse
    {
        $cart = session('cart', ['business_id' => null, 'items' => []]);

        unset($cart['items'][$item->id]);

        session(['cart' => $cart]);

        return back()->with('status', "{$item->name} removed from cart.");
    }

    public function show(): View
    {
        $cart = session('cart', ['business_id' => null, 'items' => []]);

        $items = collect();
        $total = 0;

        if ($cart['business_id']) {
            $itemIds = array_keys($cart['items']);
            $dbItems = Item::whereIn('id', $itemIds)->get()->keyBy('id');

            foreach ($cart['items'] as $itemId => $details) {
                if ($dbItems->has($itemId)) {
                    $item = $dbItems[$itemId];
                    $lineTotal = $item->price * $details['quantity'];
                    $total += $lineTotal;

                    $items->push([
                        'item' => $item,
                        'quantity' => $details['quantity'],
                        'line_total' => $lineTotal,
                    ]);
                }
            }
        }

        $business = $cart['business_id'] ? Business::find($cart['business_id']) : null;

        return view('cart.show', compact('items', 'total', 'business'));
    }
}
