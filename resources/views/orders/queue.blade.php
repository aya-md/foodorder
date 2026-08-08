<x-layouts.console title="Order Queue">
    <div class="page-head">
        <div>
            <div class="eyebrow">Vendor Console</div>
            <h1>Order Queue</h1>
        </div>
        <div class="mono" style="color:var(--amber);">{{ $activeCount }} active {{ Str::plural('order', $activeCount) }}</div>
    </div>
    <div class="queue-grid">
        @foreach ($columns as $key => $column)
            <div class="queue-col">
                <div class="queue-col-head">
                    <span class="dot {{ $column['dot'] }} {{ $column['pulse'] ? 'pulse' : '' }}"></span>
                    {{ $column['label'] }}
                    <span class="count">{{ $column['orders']->count() }}</span>
                </div>
                @forelse ($column['orders'] as $order)
                    <div class="ticket-card">
                        <div class="ticket-top">
                            <span class="ticket-id mono">#{{ $order->id }}</span>
                            <span class="ticket-time mono">{{ $order->created_at->diffForHumans(null, true) }} ago</span>
                        </div>
                        <div class="ticket-items">
                            @foreach ($order->items as $orderItem)
                                <div>{{ $orderItem->quantity }}x {{ $orderItem->item->name ?? 'Item removed' }}</div>
                            @endforeach
                        </div>
                        <div class="ticket-footer">
                            <span class="ticket-price mono">{{ number_format($order->total, 2) }} {{ config('app.currency') }}</span>
                            <div class="ticket-actions">
                                @if ($key === 'pending')
                                    <form method="POST" action="{{ route('orders.preparing', $order) }}">
                                        @csrf @method('PATCH')
                                        <button class="act-btn amber">Accept</button>
                                    </form>
                                @elseif ($key === 'preparing')
                                    <form method="POST" action="{{ route('orders.ready', $order) }}">
                                        @csrf @method('PATCH')
                                        <button class="act-btn mint">Mark Ready</button>
                                    </form>
                                @elseif ($key === 'ready')
                                    <form method="POST" action="{{ route('orders.completed', $order) }}">
                                        @csrf @method('PATCH')
                                        <button class="act-btn mint">Complete</button>
                                    </form>
                                @endif
                                @if ($key !== 'completed')
                                    <form method="POST" action="{{ route('orders.cancel', $order) }}">
                                        @csrf @method('PATCH')
                                        <button class="act-btn chili" onclick="return confirm('Cancel this order?')">Cancel</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="mono" style="color:var(--paper-dim);font-size:12px;padding:10px 0;">No orders</p>
                @endforelse
            </div>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.Echo.private(`business.{{ auth()->user()->business_id }}.orders`)
                .listen('.order.created', (e) => {
                    window.location.reload();
                })
                .listen('.order.status.updated', (e) => {
                    window.location.reload();
                });
        });
    </script>
</x-layouts.console>
