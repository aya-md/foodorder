<x-guest-layout>
    @if (session('status'))
        <div class="flash" style="background:#1E3A2E;color:#7FBF8E;margin-bottom:16px;">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-field">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')<p class="mono" style="color:var(--chili);font-size:11.5px;margin-top:4px;">{{ $message }}</p>@enderror
        </div>

        <div class="form-field">
            <label>Password</label>
            <input type="password" name="password" required autocomplete="current-password">
            @error('password')<p class="mono" style="color:var(--chili);font-size:11.5px;margin-top:4px;">{{ $message }}</p>@enderror
        </div>

        <div class="form-field" style="display:flex;align-items:center;gap:8px;">
            <input type="checkbox" id="remember_me" name="remember" style="width:auto;">
            <label for="remember_me" style="margin:0;font-weight:400;">Remember me</label>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:20px;">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="mono" style="font-size:12px;color:var(--paper-dim);text-decoration:underline;">Forgot your password?</a>
            @endif
            <button type="submit" class="act-btn mint">Log in</button>
        </div>
    </form>
</x-guest-layout>
