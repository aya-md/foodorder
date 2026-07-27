<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Options for :item', ['item' => $item->name]) }}
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
                    <a href="{{ route('items.option-groups.create', $item) }}" class="text-indigo-600 underline">
                        + Add Option Group
                    </a>
                </div>

                @forelse ($optionGroups as $group)
                    <div class="border rounded p-4 mb-4">
                        <div class="flex justify-between items-center">
                            <h3 class="font-semibold">{{ $group->name }}</h3>
                            <div>
                                <a href="{{ route('option-groups.edit', $group) }}" class="text-blue-600 underline text-sm">Edit</a>
                                <form method="POST" action="{{ route('option-groups.destroy', $group) }}" class="inline ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 underline text-sm" onclick="return confirm('Delete this option group?')">Delete</button>
                                </form>
                            </div>
                        </div>

                        <ul class="mt-2 text-sm text-gray-600">
                            @forelse ($group->options as $option)
                                <li class="flex justify-between items-center py-1">
                                    <span>{{ $option->label }} (+{{ number_format($option->extra_price, 2) }} {{ config('app.currency') }})</span>
                                    <span>
                                        <a href="{{ route('options.edit', $option) }}" class="text-blue-600 underline">Edit</a>
                                        <form method="POST" action="{{ route('options.destroy', $option) }}" class="inline ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 underline" onclick="return confirm('Delete this option?')">Delete</button>
                                        </form>
                                    </span>
                                </li>
                            @empty
                                <li class="text-gray-400">No options yet.</li>
                            @endforelse
                        </ul>

                        <a href="{{ route('option-groups.options.create', $group) }}" class="text-indigo-600 underline text-sm">+ Add Option</a>
                    </div>
                @empty
                    <p class="text-gray-500">No option groups yet.</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
