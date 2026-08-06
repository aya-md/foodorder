<x-layouts.console title="Options">
    <div class="page-head">
        <div>
            <div class="eyebrow">Vendor Console</div>
            <h1>Options for {{ $item->name }}</h1>
        </div>
        <a href="{{ route('items.option-groups.create', $item) }}" class="act-btn mint">+ Add Option Group</a>
    </div>

    <div class="wrap" style="padding:20px 40px 40px;">
        @forelse ($optionGroups as $group)
            <div class="panel" style="padding:18px 22px;margin-bottom:16px;">
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <h3 style="font-weight:700;font-size:15px;margin:0;">{{ $group->name }}</h3>
                    <div>
                        <a href="{{ route('option-groups.edit', $group) }}" class="act-btn amber">Edit</a>
                        <form method="POST" action="{{ route('option-groups.destroy', $group) }}" class="inline" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="act-btn chili" onclick="return confirm('Delete this option group?')">Delete</button>
                        </form>
                    </div>
                </div>

                <ul style="margin:14px 0 0;padding:0;list-style:none;">
                    @forelse ($group->options as $option)
                        <li style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px dashed var(--line);font-size:13.5px;">
                            <span>{{ $option->label }} <span class="mono" style="color:var(--amber);">(+{{ number_format($option->extra_price, 2) }} {{ config('app.currency') }})</span></span>
                            <span>
                                <a href="{{ route('options.edit', $option) }}" class="act-btn amber">Edit</a>
                                <form method="POST" action="{{ route('options.destroy', $option) }}" class="inline" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="act-btn chili" onclick="return confirm('Delete this option?')">Delete</button>
                                </form>
                            </span>
                        </li>
                    @empty
                        <li class="mono" style="color:var(--paper-dim);font-size:12.5px;padding:8px 0;">No options yet.</li>
                    @endforelse
                </ul>

                <a href="{{ route('option-groups.options.create', $group) }}" class="act-btn mint" style="display:inline-block;margin-top:12px;">+ Add Option</a>
            </div>
        @empty
            <p class="mono" style="color:var(--paper-dim);">No option groups yet.</p>
        @endforelse
    </div>
</x-layouts.console>
