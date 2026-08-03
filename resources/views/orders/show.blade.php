<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order #{{ $order->id }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-xl mx-auto py-10 px-4">
        <div class="bg-white rounded-lg shadow-sm p-6">

            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <h1 class="text-xl font-bold mb-1">Order #{{ $order->id }}</h1>
            <p class="text-sm text-gray-500 mb-4">Thanks, {{ $order->customer_name }}!</p>

            <div class="mb-4">
                <span class="inline-block px-3 py-1 rounded text-sm font-medium
                    @if ($order->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif ($order->status === 'preparing') bg-blue-100 text-blue-800
                    @elseif ($order->status === 'ready') bg-indigo-100 text-indigo-800
                    @elseif ($order->status === 'completed') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </span>
            </div>

            <p class="text-sm text-gray-600 mb-4">
                {{ $order->type === 'dine_in' ? 'Dine-in, table '.$order->table_number : 'Takeaway' }}
            </p>

            <div class="border-t pt-4">
                @foreach ($order->items as $orderItem)
                    <div class="flex justify-between text-sm py-1">
                        <span>{{ $orderItem->quantity }}x {{ $orderItem->item->name ?? 'Item removed' }}</span>
                        <span>{{ number_format($orderItem->unit_price * $orderItem->quantity, 2) }} {{ config('app.currency') }}</span>
                    </div>
                @endforeach
            </div>

            <div class="border-t mt-4 pt-4 flex justify-between font-semibold">
                <span>Total</span>
                <span>{{ number_format($order->total, 2) }} {{ config('app.currency') }}</span>
            </div>
            <div class="mt-6 flex justify-center gap-4 text-sm">
                <a href="{{ route('menu.show', $order->business->slug) }}" class="text-indigo-600 underline">
                  Order Again
                </a>
                <a href="{{ route('orders.mine') }}" class="text-indigo-600 underline">
                   My Orders
                </a>
</div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
           window.Echo.channel('order.{{ $order->tracking_uuid }}')
              .listen('.order.status.updated', (e) => {
                 window.location.reload();
              });
       });
    </script>
</body>
</html>
