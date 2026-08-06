<x-layouts.console title="Add Option">
    <div class="page-head">
        <div>
            <div class="eyebrow">Vendor Console</div>
            <h1>Add Option to {{ $optionGroup->name }}</h1>
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

    <form method="POST" action="{{ route('option-groups.options.store', $optionGroup) }}" class="panel form-panel">
        @csrf

        <div class="form-field">
            <label>Option Label (e.g. Large, Extra Cheese)</label>
            <input type="text" name="label" value="{{ old('label') }}" required autofocus>
        </div>

        <div class="form-field">
            <label>Extra Price in {{ config('app.currency') }} (0 if none)</label>
            <input type="number" step="0.01" min="0" name="extra_price" value="{{ old('extra_price', 0) }}" required>
        </div>

        <button type="submit" class="act-btn mint">Save</button>
    </form>
</x-layouts.console>
