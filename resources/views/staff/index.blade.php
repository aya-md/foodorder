<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Accounts') }}
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
                    <a href="{{ route('staff.create') }}" class="text-indigo-600 underline">
                        + Add Staff Account
                    </a>
                </div>

                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Name</th>
                            <th class="py-2">Email</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($staff as $member)
                            <tr class="border-b">
                                <td class="py-2">{{ $member->name }}</td>
                                <td class="py-2">{{ $member->email }}</td>
                                <td class="py-2">
                                    <form method="POST" action="{{ route('staff.destroy', $member) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 underline" onclick="return confirm('Remove this staff account?')">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-gray-500">No staff accounts yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
