<x-layouts.ticket title="Order #{{ $order->id }}">
    <div class="receipt-card" style="border-radius:8px;margin-top:24px;position:relative;">
        @if (session('status'))
            <div class="flash success">{{ session('status') }}</div>
        @endif

        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:4px;">
            <div>
                <h1 style="margin:0;font-size:19px;font-weight:700;">Order #{{ $order->id }}</h1>
                <p style="font-size:13px;color:var(--ink-dim);margin:2px 0 0;">Thanks, {{ $order->customer_name }}!</p>
            </div>
            <span class="stamp {{ $order->status }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
        </div>

        <p class="mono" style="font-size:12px;color:var(--ink-dim);margin:14px 0 18px;">
            {{ $order->type === 'dine_in' ? 'Dine-in, table '.$order->table_number : 'Takeaway' }}
        </p>

        <div style="border-top:1px dashed var(--line);padding-top:6px;">
            @foreach ($order->items as $orderItem)
                <div class="line-item" style="padding:8px 0;">
                    <span class="name">{{ $orderItem->quantity }}x {{ $orderItem->item->name ?? 'Item removed' }}</span>
                    <span class="leader"></span>
                    <span class="price">{{ number_format($orderItem->unit_price * $orderItem->quantity, 2) }} {{ config('app.currency') }}</span>
                </div>
            @endforeach
        </div>

        <div class="line-item mono" style="border-bottom:none;border-top:1px solid var(--ink);margin-top:6px;padding-top:14px;font-weight:700;">
            <span class="name" style="font-family:'Archivo',sans-serif;font-weight:700;">Total</span>
            <span class="leader" style="border:none;"></span>
            <span class="price" style="font-size:15px;">{{ number_format($order->total, 2) }} {{ config('app.currency') }}</span>
        </div>

        <div style="margin-top:22px;display:flex;justify-content:center;gap:20px;">
            <a href="{{ route('menu.show', $order->business->slug) }}" class="link">Order Again</a>
            <a href="{{ route('orders.mine') }}" class="link">My Orders</a>
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
</x-layouts.ticket>
