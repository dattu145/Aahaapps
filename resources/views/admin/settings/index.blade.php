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

                        <div class="mb-4">
                            <label for="whatsapp_number" class="block text-sm font-medium text-gray-700">WhatsApp Number</label>
                            <input type="text" name="whatsapp_number" id="whatsapp_number" value="{{ $whatsapp_number }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. 919876543210">
                            <p class="text-xs text-gray-500 mt-1">Enter number with country code, without + or spaces.</p>
                        </div>

                        <div class="mb-4">
                            <label for="min_login_url" class="block text-sm font-medium text-gray-700">Default Login URL</label>
                            <input type="url" name="min_login_url" id="min_login_url" value="{{ $min_login_url ?? 'https://profile.aahaapps.com/' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <x-primary-button>{{ __('Save Settings') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
