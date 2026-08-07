<x-layouts.ticket title="Your Cart">
    <div class="header-band torn-bottom">
        <h1>Your Cart</h1>
        @if ($business)
            <p class="sub">Ordering from {{ $business->name }}</p>
        @endif
    </div>

    <div class="receipt-card">
        @if (session('status'))
            <div class="flash success">{{ session('status') }}</div>
        @endif

        @if ($business)
            <a href="{{ route('menu.show', $business->slug) }}" class="link">← Continue Shopping</a>
            <div style="margin-top:14px;"></div>
        @endif

        @forelse ($items as $entry)
            <div class="line-item" style="align-items:center;">
                <span class="name">{{ $entry['item']->name }}</span>

                <div style="display:flex;align-items:center;gap:8px;margin:0 10px;">
                    <form method="POST" action="{{ route('cart.decrease', $entry['item']) }}">
                        @csrf @method('PATCH')
                        <button type="submit" style="width:24px;height:24px;border:1px solid var(--line);background:var(--paper-2);border-radius:4px;font-family:'IBM Plex Mono',monospace;color:var(--ink);cursor:pointer;">−</button>
                    </form>
                    <span class="mono" style="min-width:16px;text-align:center;">{{ $entry['quantity'] }}</span>
                    <form method="POST" action="{{ route('cart.add', $entry['item']) }}">
                        @csrf
                        <button type="submit" style="width:24px;height:24px;border:1px solid var(--line);background:var(--paper-2);border-radius:4px;font-family:'IBM Plex Mono',monospace;color:var(--ink);cursor:pointer;">+</button>
                    </form>
                </div>

                <span class="leader"></span>
                <span class="price">{{ number_format($entry['line_total'], 2) }} {{ config('app.currency') }}</span>

                <form method="POST" action="{{ route('cart.remove', $entry['item']) }}" style="margin-left:8px;">
                    @csrf @method('DELETE')
                    <button type="submit" class="mono" style="background:none;border:none;color:var(--stamp-dim);font-size:11px;text-decoration:underline;cursor:pointer;padding:0;">Remove</button>
                </form>
            </div>
        @empty
            <p style="color:var(--ink-dim);">Your cart is empty.</p>
        @endforelse

        @if ($items->isNotEmpty())
            <div class="line-item mono" style="border-bottom:none;border-top:1px solid var(--ink);margin-top:6px;padding-top:14px;font-weight:700;">
                <span class="name" style="font-family:'Archivo',sans-serif;font-weight:700;">Total</span>
                <span class="leader" style="border:none;"></span>
                <span class="price" style="font-size:15px;">{{ number_format($total, 2) }} {{ config('app.currency') }}</span>
            </div>

            <a href="{{ route('checkout.create') }}" class="btn-primary" style="margin-top:20px;">Proceed to Checkout</a>
        @endif
    </div>
</x-layouts.ticket>
