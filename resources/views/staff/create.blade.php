<x-layouts.console title="Add Staff Account">
    <div class="page-head">
        <div>
            <div class="eyebrow">Vendor Console</div>
            <h1>Add Staff Account</h1>
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

    <form method="POST" action="{{ route('staff.store') }}" class="panel form-panel">
        @csrf

        <div class="form-field">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="form-field">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-field">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-field">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit" class="act-btn mint">Create Staff Account</button>
    </form>
</x-layouts.console>
