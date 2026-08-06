<x-layouts.console title="Edit Item">
    <div class="page-head">
        <div>
            <div class="eyebrow">Vendor Console</div>
            <h1>Edit Item</h1>
        </div>
    </div>

    @if ($errors->any())
        <div class="form-errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('items.update', $item) }}" enctype="multipart/form-data" class="panel form-panel">
        @csrf
        @method('PATCH')

        <div class="form-field">
            <label>Category</label>
            <select name="category_id" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $item->category_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-field">
            <label>Item Name</label>
            <input type="text" name="name" value="{{ old('name', $item->name) }}" required autofocus>
        </div>

        <div class="form-field">
            <label>Description</label>
            <textarea name="description" rows="3">{{ old('description', $item->description) }}</textarea>
        </div>

        <div class="form-field">
            <label>Price ({{ config('app.currency') }})</label>
            <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $item->price) }}" required>
        </div>

        <div class="form-field">
            <label style="display:flex;align-items:center;gap:8px;flex-direction:row;">
                <input type="checkbox" name="available" value="1" @checked(old('available', $item->available)) style="width:auto;">
                Available for order
            </label>
        </div>

        <div class="form-field">
            <label>Current Photo</label>
            @if ($item->image)
                <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" style="width:80px;height:80px;border-radius:8px;object-fit:cover;border:1px solid var(--line);display:block;margin-top:6px;">
            @else
                <p class="mono" style="color:var(--paper-dim);font-size:12px;margin-top:6px;">No photo uploaded yet.</p>
            @endif
        </div>

        <div class="form-field">
            <label>Replace Photo (optional)</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <button type="submit" class="act-btn mint">Update</button>
    </form>
</x-layouts.console>
