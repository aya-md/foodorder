<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $business->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-sm rounded-lg p-8 max-w-md text-center">
        <h1 class="text-xl font-semibold mb-2">{{ $business->name }}</h1>

        @if ($business->status === 'pending')
            <p class="text-gray-600">
                This business is still being reviewed and isn't accepting orders yet. Please check back soon.
            </p>
        @elseif ($business->status === 'suspended')
            <p class="text-gray-600">
                This business is temporarily unavailable and isn't accepting orders right now.
            </p>
        @endif
    </div>
</body>
</html>
