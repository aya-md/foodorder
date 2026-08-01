<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($business)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold">{{ $business->name }}</h3>

                    <p class="mt-1">
                        Status:
                        @if ($business->status === 'approved')
                            <span class="text-green-600 font-semibold">Approved</span>
                        @elseif ($business->status === 'pending')
                            <span class="text-yellow-600 font-semibold">Pending Approval</span>
                        @else
                            <span class="text-red-600 font-semibold">Suspended</span>
                        @endif
                    </p>

                    @if ($business->status === 'pending')
                        <p class="mt-2 text-sm text-gray-600">
                            Your business is awaiting approval. You can still prepare your menu in the meantime — it just won't be visible to customers until approved.
                        </p>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if ($user->role === 'owner')
                        <a href="{{ route('categories.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                            <h3 class="text-lg font-semibold">Categories</h3>
                            <p class="text-gray-600 mt-1">{{ $categoryCount }} {{ Str::plural('category', $categoryCount) }}</p>
                        </a>

                        <a href="{{ route('items.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                            <h3 class="text-lg font-semibold">Items</h3>
                            <p class="text-gray-600 mt-1">{{ $itemCount }} {{ Str::plural('item', $itemCount) }}</p>
                        </a>

                        <a href="{{ route('staff.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                            <h3 class="text-lg font-semibold">Staff</h3>
                            <p class="text-gray-600 mt-1">Manage staff accounts</p>
                        </a>
                        <a href="{{ route('stats.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                            <h3 class="text-lg font-semibold">Stats</h3>
                            <p class="text-gray-600 mt-1">View today's performance</p>
                        </a>
                    @endif

                    <a href="{{ route('orders.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                        <h3 class="text-lg font-semibold">Order Queue</h3>
                        <p class="text-gray-600 mt-1">{{ $activeOrderCount }} active {{ Str::plural('order', $activeOrderCount) }}</p>
                    </a>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    {{ __("You're logged in!") }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
