<x-layouts.console title="Edit Category">
    <div class="page-head">
        <div>
            <div class="eyebrow">Vendor Console</div>
            <h1>Edit Category</h1>
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

    <form method="POST" action="{{ route('categories.update', $category) }}" class="panel form-panel">
        @csrf
        @method('PUT')

        <div class="form-field">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
        </div>

        <div class="form-field">
            <label>Position</label>
            <input type="number" name="position" value="{{ old('position', $category->position) }}">
        </div>

        <button type="submit" class="act-btn mint">Update Category</button>
    </form>
</x-layouts.console>
