<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Table QR Codes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('tables.update') }}" class="mb-6 flex items-end gap-3">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-sm font-medium">Number of Tables</label>
                    <input type="number" name="table_count" value="{{ $business->table_count }}" min="1" max="200" class="mt-1 border-gray-300 rounded-md">
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Update</button>
            </form>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($tables as $table)
                    <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                        <p class="font-semibold mb-2">Table {{ $table['number'] }}</p>
                        <img src="{{ $table['qr_image'] }}" alt="QR code for table {{ $table['number'] }}" class="mx-auto">
                        <a href="{{ $table['qr_image'] }}" download="table-{{ $table['number'] }}.png" class="text-xs text-indigo-600 underline mt-2 inline-block">Download</a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
