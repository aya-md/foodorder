<x-layouts.console title="Edit Option">
    <div class="page-head">
        <div>
            <div class="eyebrow">Vendor Console</div>
            <h1>Edit Option</h1>
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

    <form method="POST" action="{{ route('options.update', $option) }}" class="panel form-panel">
        @csrf
        @method('PATCH')

        <div class="form-field">
            <label>Option Label</label>
            <input type="text" name="label" value="{{ old('label', $option->label) }}" required autofocus>
        </div>

        <div class="form-field">
            <label>Extra Price ({{ config('app.currency') }})</label>
            <input type="number" step="0.01" min="0" name="extra_price" value="{{ old('extra_price', $option->extra_price) }}" required>
        </div>

        <button type="submit" class="act-btn mint">Update</button>
    </form>
</x-layouts.console>
