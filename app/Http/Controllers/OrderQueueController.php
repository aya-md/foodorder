<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Events\OrderStatusUpdated;

class OrderQueueController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('items.item')
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->orderBy('created_at')
            ->get();

        return view('orders.queue', compact('orders'));
    }

    public function markPreparing(Order $order): RedirectResponse
{
    $order->update(['status' => 'preparing']);
    event(new OrderStatusUpdated($order));

    return back()->with('status', "Order #{$order->id} marked as preparing.");
}

public function markReady(Order $order): RedirectResponse
{
    $order->update(['status' => 'ready']);
    event(new OrderStatusUpdated($order));

    return back()->with('status', "Order #{$order->id} marked as ready.");
}

public function markCompleted(Order $order): RedirectResponse
{
    $order->update(['status' => 'completed']);
    event(new OrderStatusUpdated($order));

    return back()->with('status', "Order #{$order->id} marked as completed.");
}

public function cancel(Order $order): RedirectResponse
{
    $order->update(['status' => 'cancelled']);
    event(new OrderStatusUpdated($order));

    return back()->with('status', "Order #{$order->id} cancelled.");
}
}
