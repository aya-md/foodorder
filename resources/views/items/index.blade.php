<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menu Items') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('status'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="mb-4">
                    <a href="{{ route('items.create') }}" class="text-indigo-600 underline">
                        + Add Item
                    </a>
                </div>

                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                              <th class="py-2">Photo</th>
                              <th class="py-2">Name</th>
                              <th class="py-2">Category</th>
                              <th class="py-2">Price</th>
                              <th class="py-2">Available</th>
                               <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr class="border-b">
                                <td class="py-2">
                                   @if ($item->image)
                                         <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="w-12 h-12 object-cover rounded">
                                   @else
                                         <span class="text-gray-400 text-sm">No photo</span>
                                   @endif
                                </td>
                                <td class="py-2">{{ $item->name }}</td>
                                <td class="py-2">{{ $item->category->name }}</td>
                                <td class="py-2">{{ $item->price }}</td>
                                <td class="py-2">{{ $item->available ? 'Yes' : 'No' }}</td>
                                <td class="py-2">
                                    <a href="{{ route('items.edit', $item) }}" class="text-blue-600 underline">Edit</a>

                                    <form method="POST" action="{{ route('items.destroy', $item) }}" class="inline ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 underline" onclick="return confirm('Delete this item?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-gray-500">No items yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
