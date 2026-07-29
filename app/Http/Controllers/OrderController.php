<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function create(): View|RedirectResponse
    {
        $cart = session('cart', ['business_id' => null, 'items' => []]);

        if (! $cart['business_id'] || empty($cart['items'])) {
            return redirect()->route('cart.show')->with('status', 'Your cart is empty.');
        }

        $business = Business::find($cart['business_id']);

        return view('orders.create', compact('business'));
    }

    public function store(Request $request): RedirectResponse
    {
        $cart = session('cart', ['business_id' => null, 'items' => []]);

        if (! $cart['business_id'] || empty($cart['items'])) {
            return redirect()->route('cart.show')->with('status', 'Your cart is empty.');
        }

        $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'type' => ['required', 'in:dine_in,take_away'],
            'table_number' => ['required_if:type,dine_in', 'nullable', 'string', 'max:50'],
        ]);

        $business = Business::findOrFail($cart['business_id']);

        $itemIds = array_keys($cart['items']);
        $items = Item::whereIn('id', $itemIds)->where('available', true)->get()->keyBy('id');

        $unavailable = [];
        $total = 0;
        $orderItemsData = [];

        foreach ($cart['items'] as $itemId => $details) {
            if (! $items->has($itemId)) {
                $unavailable[] = $itemId;
                continue;
            }

            $item = $items[$itemId];
            $lineTotal = $item->price * $details['quantity'];
            $total += $lineTotal;

            $orderItemsData[] = [
                'item_id' => $item->id,
                'business_id' => $business->id,
                'quantity' => $details['quantity'],
                'unit_price' => $item->price,
            ];
        }

        if (! empty($unavailable)) {
            foreach ($unavailable as $id) {
                unset($cart['items'][$id]);
            }
            session(['cart' => $cart]);

            return redirect()->route('checkout.create')
                ->with('status', 'Some items in your cart are no longer available and were removed. Please review your order.');
        }

        $order = Order::create([
            'business_id' => $business->id,
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'type' => $request->type,
            'table_number' => $request->table_number,
            'status' => 'pending',
            'total' => $total,
        ]);

        foreach ($orderItemsData as $data) {
            $order->items()->create($data);
        }

        session()->forget('cart');

        return redirect()->route('orders.show', $order->tracking_uuid)->with('status', 'Order placed successfully!');
    }
}
