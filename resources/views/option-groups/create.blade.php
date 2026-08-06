<x-layouts.console title="Add Option Group">
    <div class="page-head">
        <div>
            <div class="eyebrow">Vendor Console</div>
            <h1>Add Option Group</h1>
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

    <form method="POST" action="{{ route('items.option-groups.store', $item) }}" class="panel form-panel">
        @csrf

        <div class="form-field">
            <label>Group Name (e.g. Size, Extras)</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <button type="submit" class="act-btn mint">Save</button>
    </form>
</x-layouts.console>
