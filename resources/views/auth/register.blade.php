<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-field">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            @error('name')<p class="mono" style="color:var(--chili);font-size:11.5px;margin-top:4px;">{{ $message }}</p>@enderror
        </div>

        <div class="form-field">
            <label>Business Name</label>
            <input type="text" name="business_name" value="{{ old('business_name') }}" required autocomplete="organization">
            @error('business_name')<p class="mono" style="color:var(--chili);font-size:11.5px;margin-top:4px;">{{ $message }}</p>@enderror
        </div>

        <div class="form-field">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            @error('email')<p class="mono" style="color:var(--chili);font-size:11.5px;margin-top:4px;">{{ $message }}</p>@enderror
        </div>

        <div class="form-field">
            <label>Password</label>
            <input type="password" name="password" required autocomplete="new-password">
            @error('password')<p class="mono" style="color:var(--chili);font-size:11.5px;margin-top:4px;">{{ $message }}</p>@enderror
        </div>

        <div class="form-field">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required autocomplete="new-password">
            @error('password_confirmation')<p class="mono" style="color:var(--chili);font-size:11.5px;margin-top:4px;">{{ $message }}</p>@enderror
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:20px;">
            <a href="{{ route('login') }}" class="mono" style="font-size:12px;color:var(--paper-dim);text-decoration:underline;">Already registered?</a>
            <button type="submit" class="act-btn mint">Register</button>
        </div>
    </form>
</x-guest-layout>
