<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'FoodOrder') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="console">
        <div style="min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px;">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
                <div class="brand-mark">F</div>
                <div class="brand-text">FOODORDER</div>
            </div>

            <div class="panel form-panel" style="margin:0;max-width:520px;width:100%;">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
