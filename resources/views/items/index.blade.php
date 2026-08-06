<x-layouts.console title="Items">
    <div class="page-head">
        <div>
            <div class="eyebrow">Vendor Console</div>
            <h1>Menu Items</h1>
        </div>
        <a href="{{ route('items.create') }}" class="act-btn mint">+ Add Item</a>
    </div>

    <div class="wrap" style="padding:20px 40px 40px;">
        <div class="panel">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th class="mono" style="text-align:left;font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--paper-dim);padding:16px 22px;border-bottom:1px solid var(--line);font-weight:500;">Item</th>
                        <th class="mono" style="text-align:left;font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--paper-dim);padding:16px 22px;border-bottom:1px solid var(--line);font-weight:500;">Category</th>
                        <th class="mono" style="text-align:left;font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--paper-dim);padding:16px 22px;border-bottom:1px solid var(--line);font-weight:500;">Price</th>
                        <th class="mono" style="text-align:left;font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--paper-dim);padding:16px 22px;border-bottom:1px solid var(--line);font-weight:500;">Available</th>
                        <th class="mono" style="text-align:right;font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--paper-dim);padding:16px 22px;border-bottom:1px solid var(--line);font-weight:500;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td style="padding:16px 22px;border-bottom:1px dashed var(--line);">
                                <div style="display:flex;align-items:center;gap:12px;">
                                    @if ($item->image)
                                        <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" style="width:38px;height:38px;border-radius:8px;object-fit:cover;border:1px solid var(--line);">
                                    @else
                                        <div style="width:38px;height:38px;border-radius:8px;background:var(--panel-2);border:1px solid var(--line);display:flex;align-items:center;justify-content:center;font-size:16px;color:var(--amber);flex-shrink:0;">🍽</div>
                                    @endif
                                    <span style="font-weight:700;">{{ $item->name }}</span>
                                </div>
                            </td>
                            <td class="mono" style="padding:16px 22px;border-bottom:1px dashed var(--line);color:var(--paper-dim);font-size:12.5px;">{{ $item->category->name }}</td>
                            <td class="mono" style="padding:16px 22px;border-bottom:1px dashed var(--line);color:var(--amber);font-weight:700;">{{ number_format($item->price, 2) }} {{ config('app.currency') }}</td>
                            <td style="padding:16px 22px;border-bottom:1px dashed var(--line);">
                                @if ($item->available)
                                    <span class="status-pill approved"><span class="dot"></span>Yes</span>
                                @else
                                    <span class="status-pill suspended"><span class="dot"></span>No</span>
                                @endif
                            </td>
                            <td style="padding:16px 22px;border-bottom:1px dashed var(--line);text-align:right;">
                                <a href="{{ route('items.option-groups.index', $item) }}" class="act-btn amber">Options</a>
                                <a href="{{ route('items.edit', $item) }}" class="act-btn mint">Edit</a>
                                <form method="POST" action="{{ route('items.destroy', $item) }}" class="inline" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="act-btn chili" onclick="return confirm('Delete this item?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="mono" style="padding:20px 22px;color:var(--paper-dim);">No items yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.console>
