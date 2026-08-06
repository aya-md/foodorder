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
        ->get()
        ->groupBy('status');

    $completedToday = Order::with('items.item')
        ->whereDate('updated_at', today())
        ->where('status', 'completed')
        ->latest()
        ->get();

    $columns = [
        'pending' => ['label' => 'Pending', 'dot' => 'chili', 'pulse' => true, 'orders' => $orders->get('pending', collect())],
        'preparing' => ['label' => 'Preparing', 'dot' => 'amber', 'pulse' => false, 'orders' => $orders->get('preparing', collect())],
        'ready' => ['label' => 'Ready', 'dot' => 'mint', 'pulse' => false, 'orders' => $orders->get('ready', collect())],
        'completed' => ['label' => 'Completed Today', 'dot' => 'dim', 'pulse' => false, 'orders' => $completedToday],
    ];

    $activeCount = $orders->flatten()->count();

    return view('orders.queue', compact('columns', 'activeCount'));
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
