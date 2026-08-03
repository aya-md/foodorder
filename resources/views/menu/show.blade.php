<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $business->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-3xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6">{{ $business->name }}</h1>
        @if (session('status'))
           <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
              {{ session('status') }}
           </div>
        @endif
        @if ($cartCount > 0)
           <div class="mb-4">
              <a href="{{ route('cart.show') }}" class="inline-block bg-indigo-600 text-white text-sm px-3 py-1.5 rounded">
                 🛒 View Cart ({{ $cartCount }} {{ Str::plural('item', $cartCount) }})
              </a>
              <a href="{{ route('orders.mine') }}" class="text-sm text-gray-600 underline">My Orders</a>
    </div>
@endif
        @forelse ($categories as $category)
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-3">{{ $category->name }}</h2>

                <div class="bg-white rounded-lg shadow-sm divide-y">
                    @forelse ($category->items as $item)
                       <div class="p-4 flex justify-between items-center">
                          <div>
                              <p class="font-medium">{{ $item->name }}</p>
                              @if ($item->description)
                                   <p class="text-sm text-gray-500">{{ $item->description }}</p>
                              @endif
                          </div>
                          <div class="flex items-center gap-4">
                               <p class="font-semibold">{{ number_format($item->price, 2) }} {{ config('app.currency') }}</p>
                               <form method="POST" action="{{ route('cart.add', $item) }}">
                                   @csrf
                                   <button type="submit" class="bg-indigo-600 text-white text-sm px-3 py-1.5 rounded">Add</button>
                               </form>
                          </div>
                       </div>
                       @empty
                       <p class="p-4 text-gray-400 text-sm">No items available in this category right now.</p>
                   @endforelse
              </div>
           </div>
           @empty
           <p class="text-gray-500">This business hasn't added a menu yet.</p>
        @endforelse
    </div>
</body>
</html>
