<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'FoodOrder' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="console">
    <div class="topbar">
        <div class="brand">
            <div class="brand-mark">F</div>
            <div>
                <div class="brand-text">FOODORDER</div>
                <div class="brand-sub">
                    @if (Auth::user()->role === 'super_admin')
                        Platform Admin
                    @else
                        {{ Auth::user()->business->name ?? 'Vendor Console' }}
                    @endif
                </div>
            </div>
        </div>
        <div class="topbar-right">
            <span><span class="dot-live"></span> System live</span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="user-chip">👤 {{ Auth::user()->name }}</button>
            </form>
        </div>
    </div>

    <div class="subnav">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>

        @if (Auth::user()->role === 'owner')
            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">Categories</a>
            <a href="{{ route('items.index') }}" class="{{ request()->routeIs('items.*') ? 'active' : '' }}">Items</a>
            <a href="{{ route('staff.index') }}" class="{{ request()->routeIs('staff.*') ? 'active' : '' }}">Staff</a>
            <a href="{{ route('stats.index') }}" class="{{ request()->routeIs('stats.*') ? 'active' : '' }}">Stats</a>
            <a href="{{ route('tables.index') }}" class="{{ request()->routeIs('tables.*') ? 'active' : '' }}">Tables</a>
        @endif

        @if (in_array(Auth::user()->role, ['owner', 'staff']))
            <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.index') ? 'active' : '' }}">Order Queue</a>
        @endif

        @if (Auth::user()->role === 'super_admin')
            <a href="{{ route('admin.businesses.index') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">Business Approvals</a>
        @endif
    </div>

    @if (session('status'))
        <div class="status-flash">{{ session('status') }}</div>
    @endif

    {{ $slot }}

    <footer>FOODORDER · {{ Auth::user()->role === 'super_admin' ? 'PLATFORM ADMIN' : 'VENDOR CONSOLE' }}</footer>
</body>
</html>
