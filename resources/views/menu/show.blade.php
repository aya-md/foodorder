<x-layouts.ticket :title="$business->name">
    <div class="header-band torn-bottom">
        <h1>{{ $business->name }}</h1>
        <p class="sub">Order online</p>
    </div>

    <div class="receipt-card">
        @if (session('status'))
            <div class="flash success">{{ session('status') }}</div>
        @endif

        <div style="display:flex;align-items:center;gap:14px;margin-bottom:14px;flex-wrap:wrap;">
            @if ($cartCount > 0)
                <a href="{{ route('cart.show') }}" class="btn-secondary">🛒 Cart ({{ $cartCount }} {{ Str::plural('item', $cartCount) }})</a>
            @endif
            <a href="{{ route('orders.mine') }}" class="link">My Orders</a>
        </div>

        @if (session('dine_in_business_id') === $business->id)
            <p class="mono" style="font-size:12px;color:var(--ink-dim);margin:0 0 16px;">📍 Ordering for Table {{ session('dine_in_table') }}</p>
        @endif

        @forelse ($categories as $category)
            <div style="margin-bottom:24px;">
                <p class="section-label">{{ $category->name }}</p>

                @forelse ($category->items as $item)
                    <div class="item-row">
                        @if ($item->image)
                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="item-photo">
                        @else
                            <div class="item-photo-placeholder"></div>
                        @endif

                        <div class="item-info">
                            <div class="line-item" style="border-bottom:none;padding:0;">
                                <span class="name">{{ $item->name }}</span>
                                <span class="leader"></span>
                                <span class="price">{{ number_format($item->price, 2) }} {{ config('app.currency') }}</span>
                            </div>
                            @if ($item->description)
                                <p class="item-desc">{{ $item->description }}</p>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('cart.add', $item) }}">
                            @csrf
                            <button type="submit" class="btn-add">Add</button>
                        </form>
                    </div>
                @empty
                    <p class="mono" style="font-size:12.5px;color:var(--ink-dim);padding:10px 0;">No items available in this category right now.</p>
                @endforelse
            </div>
        @empty
            <p style="color:var(--ink-dim);">This business hasn't added a menu yet.</p>
        @endforelse
    </div>
</x-layouts.ticket>
