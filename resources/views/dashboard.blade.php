<x-layouts.console title="Dashboard">
    <div class="page-head">
        <div>
            <div class="eyebrow">{{ Auth::user()->role === 'super_admin' ? 'Platform Admin' : 'Vendor Console' }}</div>
            <h1>Dashboard</h1>
        </div>
    </div>

    @if ($business)
        <div class="status-block panel" style="margin:20px 40px 0;">
            <div class="status-block-info">
                <div class="biz-name">{{ $business->name }}</div>
                <div class="biz-sub">
                    @if ($business->status === 'approved')
                        Live on the marketplace
                    @elseif ($business->status === 'pending')
                        Awaiting approval — menu hidden from customers
                    @else
                        Suspended — not accepting orders
                    @endif
                </div>
                @if ($business->status === 'approved')
                    <a href="{{ route('menu.show', $business->slug) }}" target="_blank" class="act-btn mint" style="display:inline-block;margin-top:14px;">View Public Menu →</a>
                @endif
            </div>
            <div class="status-ring {{ $business->status }}">
                @if ($business->status === 'approved')
                    <span class="check">✓</span> Approved
                @elseif ($business->status === 'pending')
                    <span class="check">⏳</span> Pending
                @else
                    <span class="check">⛔</span> Suspended
                @endif
            </div>
        </div>

        <div class="dash-grid">
            @if ($user->role === 'owner')
                <a href="{{ route('categories.index') }}" class="dash-card">
                    <span class="tag">№ 01</span>
                    <p class="dash-title">Categories</p>
                    <p class="dash-sub">{{ $categoryCount }} {{ Str::plural('category', $categoryCount) }}</p>
                </a>
                <a href="{{ route('items.index') }}" class="dash-card">
                    <span class="tag">№ 02</span>
                    <p class="dash-title">Items</p>
                    <p class="dash-sub">{{ $itemCount }} {{ Str::plural('item', $itemCount) }}</p>
                </a>
                <a href="{{ route('staff.index') }}" class="dash-card">
                    <span class="tag">№ 03</span>
                    <p class="dash-title">Staff</p>
                    <p class="dash-sub">Manage accounts</p>
                </a>
                <a href="{{ route('stats.index') }}" class="dash-card">
                    <span class="tag">№ 04</span>
                    <p class="dash-title">Stats</p>
                    <p class="dash-sub">Today's performance</p>
                </a>
                <a href="{{ route('tables.index') }}" class="dash-card">
                    <span class="tag">№ 05</span>
                    <p class="dash-title">Table QR Codes</p>
                    <p class="dash-sub">Print for dine-in</p>
                </a>
            @endif
            <a href="{{ route('orders.index') }}" class="dash-card">
                <span class="tag">№ 06</span>
                <p class="dash-title">Order Queue</p>
                <p class="dash-sub">{{ $activeOrderCount }} active {{ Str::plural('order', $activeOrderCount) }}</p>
            </a>
        </div>
    @else
        <div class="dash-grid">
            <a href="{{ route('admin.businesses.index') }}" class="dash-card">
                <span class="tag">№ 01</span>
                <p class="dash-title">Business Approvals</p>
                <p class="dash-sub">Review registrations</p>
            </a>
        </div>
    @endif
</x-layouts.console>
