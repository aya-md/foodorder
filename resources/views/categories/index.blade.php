<x-layouts.console title="Categories">
    <div class="page-head">
        <div>
            <div class="eyebrow">Vendor Console</div>
            <h1>Categories</h1>
        </div>
        <a href="{{ route('categories.create') }}" class="act-btn mint">+ Add Category</a>
    </div>

    <div class="wrap" style="padding:20px 40px 40px;">
        <div class="panel">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th class="mono" style="text-align:left;font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--paper-dim);padding:16px 22px;border-bottom:1px solid var(--line);font-weight:500;">Name</th>
                        <th class="mono" style="text-align:left;font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--paper-dim);padding:16px 22px;border-bottom:1px solid var(--line);font-weight:500;">Position</th>
                        <th class="mono" style="text-align:right;font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--paper-dim);padding:16px 22px;border-bottom:1px solid var(--line);font-weight:500;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td style="padding:16px 22px;border-bottom:1px dashed var(--line);font-weight:700;">{{ $category->name }}</td>
                            <td class="mono" style="padding:16px 22px;border-bottom:1px dashed var(--line);color:var(--paper-dim);">{{ $category->position }}</td>
                            <td style="padding:16px 22px;border-bottom:1px dashed var(--line);text-align:right;">
                                <a href="{{ route('categories.edit', $category) }}" class="act-btn amber">Edit</a>
                                <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="act-btn chili" onclick="return confirm('Delete this category?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="mono" style="padding:20px 22px;color:var(--paper-dim);">No categories yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.console>
