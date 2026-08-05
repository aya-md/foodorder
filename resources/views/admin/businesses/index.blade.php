<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Business Approvals') }}
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

                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Name</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($businesses as $business)
                            <tr class="border-b">
                                <td class="py-2">{{ $business->name }}</td>
                                <td class="py-2">{{ $business->status }}</td>
                                <td class="py-2">
                                    @if ($business->status !== 'approved')
                                        <form method="POST" action="{{ route('admin.businesses.approve', $business) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-600 underline">Approve</button>
                                        </form>
                                    @endif

                                    @if ($business->status !== 'suspended')
                                        <form method="POST" action="{{ route('admin.businesses.suspend', $business) }}" class="inline ml-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-red-600 underline">{{ $business->status === 'pending' ? 'Reject' : 'Suspend' }}</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
