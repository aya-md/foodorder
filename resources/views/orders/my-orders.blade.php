<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Orders</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6">My Orders</h1>

        @forelse ($orders as $order)
            <a href="{{ route('orders.show', $order->tracking_uuid) }}" class="block bg-white rounded-lg shadow-sm p-4 mb-3 hover:bg-gray-50">
                <p class="font-medium">Order #{{ $order->id }} — {{ $order->status }}</p>
                <p class="text-sm text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
            </a>
        @empty
            <p class="text-gray-500">No recent orders found on this device.</p>
        @endforelse
    </div>
</body>
</html>
