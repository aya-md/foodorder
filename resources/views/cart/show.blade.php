<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Cart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-3xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6">Your Cart</h1>
        @if ($business)
        <a href="{{ route('menu.show', $business->slug) }}" class="text-indigo-600 underline text-sm">
             ← Continue Shopping
        </a>
        @endif

        @if ($business)
            <p class="text-gray-600 mb-4">Ordering from {{ $business->name }}</p>
        @endif

        @forelse ($items as $entry)
            <div class="bg-white rounded-lg shadow-sm p-4 mb-2 flex justify-between items-center">
                <div>
                    <p class="font-medium">{{ $entry['item']->name }}</p>
                    <p class="text-sm text-gray-500">Qty: {{ $entry['quantity'] }}</p>
                </div>
                <p class="font-semibold">{{ number_format($entry['line_total'], 2) }} {{ config('app.currency') }}</p>
            </div>
        @empty
            <p class="text-gray-500">Your cart is empty.</p>
        @endforelse
        @if ($items->isNotEmpty())
          <div class="mt-4 text-right font-bold text-lg">
              Total: {{ number_format($total, 2) }} {{ config('app.currency') }}
          </div>

          <div class="mt-4 text-right">
               <a href="{{ route('checkout.create') }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded">
                    Proceed to Checkout
               </a>
          </div>
        @endif

    </div>
</body>
</html>
