<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodOrder — Order Online</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-3xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6">Order From a Local Business</h1>

        @forelse ($businesses as $business)
            <a href="{{ route('menu.show', $business->slug) }}" class="block bg-white rounded-lg shadow-sm p-4 mb-3 hover:bg-gray-50">
                <p class="font-medium">{{ $business->name }}</p>
                @if ($business->opening_hours)
                    <p class="text-sm text-gray-500">{{ $business->opening_hours }}</p>
                @endif
            </a>
        @empty
            <p class="text-gray-500">No businesses are currently accepting orders.</p>
        @endforelse
    </div>
</body>
</html>
