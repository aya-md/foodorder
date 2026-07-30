<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Queue') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            @forelse ($orders as $order)
                <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold">Order #{{ $order->id }} — {{ $order->customer_name }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $order->type === 'dine_in' ? 'Dine-in, table '.$order->table_number : 'Takeaway' }}
                                &middot; Status: <span class="font-medium">{{ $order->status }}</span>
                            </p>
                        </div>
                        <p class="font-semibold">{{ number_format($order->total, 2) }} {{ config('app.currency') }}</p>
                    </div>

                    <ul class="mt-2 text-sm text-gray-600">
                        @foreach ($order->items as $orderItem)
                            <li>{{ $orderItem->quantity }}x {{ $orderItem->item->name ?? 'Item removed' }}</li>
                        @endforeach
                    </ul>

                    <div class="mt-3 flex gap-2">
                        @if ($order->status === 'pending')
                            <form method="POST" action="{{ route('orders.preparing', $order) }}">
                                @csrf @method('PATCH')
                                <button class="bg-blue-600 text-white text-sm px-3 py-1.5 rounded">Start Preparing</button>
                            </form>
                        @endif

                        @if ($order->status === 'preparing')
                            <form method="POST" action="{{ route('orders.ready', $order) }}">
                                @csrf @method('PATCH')
                                <button class="bg-indigo-600 text-white text-sm px-3 py-1.5 rounded">Mark Ready</button>
                            </form>
                        @endif

                        @if ($order->status === 'ready')
                            <form method="POST" action="{{ route('orders.completed', $order) }}">
                                @csrf @method('PATCH')
                                <button class="bg-green-600 text-white text-sm px-3 py-1.5 rounded">Complete</button>
                            </form>
                        @endif

                        @if (! in_array($order->status, ['completed', 'cancelled']))
                            <form method="POST" action="{{ route('orders.cancel', $order) }}">
                                @csrf @method('PATCH')
                                <button class="bg-red-600 text-white text-sm px-3 py-1.5 rounded" onclick="return confirm('Cancel this order?')">Cancel</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-sm p-6 text-gray-500">
                    No active orders right now.
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
