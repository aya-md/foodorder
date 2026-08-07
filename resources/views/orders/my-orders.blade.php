<x-layouts.ticket title="My Orders">
    <div class="header-band torn-bottom">
        <h1>My Orders</h1>
        <p class="sub">Recent orders on this device</p>
    </div>

    <div class="receipt-card">
        @forelse ($orders as $order)
            <a href="{{ route('orders.show', $order->tracking_uuid) }}" style="display:flex;justify-content:space-between;align-items:center;text-decoration:none;color:var(--ink);padding:14px 0;border-bottom:1px dashed var(--line);">
                <div>
                    <p style="font-weight:600;font-size:14px;margin:0;">Order #{{ $order->id }}</p>
                    <p class="mono" style="font-size:11.5px;color:var(--ink-dim);margin:3px 0 0;">{{ $order->created_at->diffForHumans() }}</p>
                </div>
                <span class="stamp {{ $order->status }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
            </a>
        @empty
            <p style="color:var(--ink-dim);">No recent orders found on this device.</p>
        @endforelse
    </div>
</x-layouts.ticket>
