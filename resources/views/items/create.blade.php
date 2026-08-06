<x-layouts.console title="Add Item">
    <div class="page-head">
        <div>
            <div class="eyebrow">Vendor Console</div>
            <h1>Add Item</h1>
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

    <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data" class="panel form-panel">
        @csrf

        <div class="form-field">
            <label>Category</label>
            <select name="category_id" required>
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-field">
            <label>Item Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="form-field">
            <label>Description</label>
            <textarea name="description" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="form-field">
            <label>Price ({{ config('app.currency') }})</label>
            <input type="number" step="0.01" min="0" name="price" value="{{ old('price') }}" required>
        </div>

        <div class="form-field">
            <label style="display:flex;align-items:center;gap:8px;flex-direction:row;">
                <input type="checkbox" name="available" value="1" checked style="width:auto;">
                Available for order
            </label>
        </div>

        <div class="form-field">
            <label>Item Photo (optional)</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <button type="submit" class="act-btn mint">Save</button>
    </form>
</x-layouts.console>
