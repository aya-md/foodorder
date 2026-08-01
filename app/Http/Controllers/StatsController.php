<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index(): View
    {
        $ordersToday = Order::whereDate('created_at', today())
            ->where('status', '!=', 'cancelled')
            ->count();

        $revenueToday = Order::whereDate('created_at', today())
            ->where('status', '!=', 'cancelled')
            ->sum('total');

        $topItems = OrderItem::withoutGlobalScope('business')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('items', 'items.id', '=', 'order_items.item_id')
            ->where('order_items.business_id', Auth::user()->business_id)
            ->whereDate('orders.created_at', today())
            ->where('orders.status', '!=', 'cancelled')
            ->select('items.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('items.id', 'items.name')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        return view('stats.index', compact('ordersToday', 'revenueToday', 'topItems'));
    }
}
