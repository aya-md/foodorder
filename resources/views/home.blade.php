<x-layouts.ticket title="FoodOrder — Order Online">
    <div class="header-band torn-bottom">
        <h1>FoodOrder</h1>
        <p class="sub">Order from a local business</p>
    </div>

    <div class="receipt-card">
        @forelse ($businesses as $business)
            <a href="{{ route('menu.show', $business->slug) }}" style="display:block;text-decoration:none;color:var(--ink);padding:14px 0;border-bottom:1px dashed var(--line);">
                <p style="font-weight:700;font-size:15px;margin:0;">{{ $business->name }}</p>
                @if ($business->opening_hours)
                    <p class="mono" style="font-size:11.5px;color:var(--ink-dim);margin:3px 0 0;">{{ $business->opening_hours }}</p>
                @endif
            </a>
        @empty
            <p style="color:var(--ink-dim);">No businesses are currently accepting orders.</p>
        @endforelse
    </div>
</x-layouts.ticket>
