<x-layouts.console title="Edit Option Group">
    <div class="page-head">
        <div>
            <div class="eyebrow">Vendor Console</div>
            <h1>Edit Option Group</h1>
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

    <form method="POST" action="{{ route('option-groups.update', $optionGroup) }}" class="panel form-panel">
        @csrf
        @method('PATCH')

        <div class="form-field">
            <label>Group Name</label>
            <input type="text" name="name" value="{{ old('name', $optionGroup->name) }}" required autofocus>
        </div>

        <button type="submit" class="act-btn mint">Update</button>
    </form>
</x-layouts.console>
