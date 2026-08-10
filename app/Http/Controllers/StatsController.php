<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

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

        $labels = collect(range(6, 0))->map(fn ($daysAgo) => now()->subDays($daysAgo)->format('Y-m-d'));

        $revenueByDay = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $revenueData = $labels->map(fn ($date) => (float) ($revenueByDay[$date] ?? 0));

        return view('stats.index', compact('ordersToday', 'revenueToday', 'topItems', 'labels', 'revenueData'));
    }
}
