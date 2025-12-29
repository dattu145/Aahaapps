<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
                            <input type="file" name="logo" id="logo" class="mt-1 block w-full">
                            @if($logo)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Current Logo:</p>
                                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-16 mt-1">
                                </div>
                            @endif
                        </div>
                        <x-primary-button>{{ __('Save Settings') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
