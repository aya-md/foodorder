<x-layouts.console title="Categories">
    <div class="page-head">
        <div>
            <div class="eyebrow">Vendor Console</div>
            <h1>Categories</h1>
        </div>
        <a href="{{ route('categories.create') }}" class="act-btn mint">+ Add Category</a>
    </div>

    @if (session('status'))
        <div class="status-flash">{{ session('status') }}</div>
    @endif

    <div class="wrap" style="padding:20px 40px 40px;">
        <p class="mono" style="font-size:11.5px;color:var(--paper-dim);margin:0 0 10px;">Drag rows to reorder how categories appear on the customer menu.</p>
        <div class="panel">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th class="mono" style="width:36px;padding:16px 0 16px 22px;border-bottom:1px solid var(--line);"></th>
                        <th class="mono" style="text-align:left;font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--paper-dim);padding:16px 22px;border-bottom:1px solid var(--line);font-weight:500;">Name</th>
                        <th class="mono" style="text-align:right;font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--paper-dim);padding:16px 22px;border-bottom:1px solid var(--line);font-weight:500;">Actions</th>
                    </tr>
                </thead>
                <tbody id="category-list">
                    @forelse ($categories as $category)
                        <tr data-id="{{ $category->id }}">
                            <td style="padding:16px 0 16px 22px;border-bottom:1px dashed var(--line);cursor:grab;color:var(--paper-dim);" class="drag-handle">⠿</td>
                            <td style="padding:16px 22px;border-bottom:1px dashed var(--line);font-weight:700;">{{ $category->name }}</td>
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const list = document.getElementById('category-list');
            if (!list) return;

            new Sortable(list, {
                handle: '.drag-handle',
                animation: 150,
                onEnd: function () {
                    const order = Array.from(list.querySelectorAll('tr[data-id]')).map(row => row.dataset.id);

                    fetch('{{ route('categories.reorder') }}', {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ order: order }),
                    });
                }
            });
        });
    </script>
</x-layouts.console>
