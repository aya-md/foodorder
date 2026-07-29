<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6">Checkout — {{ $business->name }}</h1>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('checkout.store') }}" class="bg-white rounded-lg shadow-sm p-6">
            @csrf

            <div>
                <label class="block text-sm font-medium">Your Name</label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}" class="block mt-1 w-full border-gray-300 rounded-md" required>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium">Phone (optional)</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="block mt-1 w-full border-gray-300 rounded-md">
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium">Order Type</label>
                <select name="type" id="type" class="block mt-1 w-full border-gray-300 rounded-md" required>
                    <option value="take_away" @selected(old('type') === 'take_away')>Take_away</option>
                    <option value="dine_in" @selected(old('type') === 'dine_in')>Dine-in</option>
                </select>
            </div>

            <div class="mt-4" id="table-field">
                <label class="block text-sm font-medium">Table Number</label>
                <input type="text" name="table_number" value="{{ old('table_number') }}" class="block mt-1 w-full border-gray-300 rounded-md">
            </div>

            <button type="submit" class="mt-6 bg-indigo-600 text-white px-4 py-2 rounded">Place Order</button>
        </form>
    </div>
</body>
</html>
