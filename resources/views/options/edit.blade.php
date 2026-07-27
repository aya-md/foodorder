<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Option') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('options.update', $option) }}">
                    @csrf
                    @method('PATCH')

                    <div>
                        <x-input-label for="label" :value="__('Option Label')" />
                        <x-text-input id="label" class="block mt-1 w-full" type="text" name="label" :value="old('label', $option->label)" required autofocus />
                        <x-input-error :messages="$errors->get('label')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="extra_price" :value="__('Extra Price (:currency)', ['currency' => config('app.currency')])" />
                        <x-text-input id="extra_price" class="block mt-1 w-full" type="number" step="0.01" min="0" name="extra_price" :value="old('extra_price', $option->extra_price)" required />
                        <x-input-error :messages="$errors->get('extra_price')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-primary-button>{{ __('Update') }}</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
