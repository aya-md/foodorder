<x-layouts.console title="Add Category">
    <div class="page-head">
        <div>
            <div class="eyebrow">Vendor Console</div>
            <h1>Add Category</h1>
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

    <form method="POST" action="{{ route('categories.store') }}" class="panel form-panel">
        @csrf

        <div class="form-field">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-field">
            <label>Position</label>
            <input type="number" name="position" value="{{ old('position', 0) }}">
        </div>

        <button type="submit" class="act-btn mint">Save Category</button>
    </form>
</x-layouts.console>
