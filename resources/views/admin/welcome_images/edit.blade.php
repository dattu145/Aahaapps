<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Scrolling Website') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.welcome-images.update', $welcomeImage) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="iframe_url" class="block text-sm font-medium text-gray-700">Website URL *</label>
                            <input type="url" name="iframe_url" id="iframe_url" value="{{ old('iframe_url', $welcomeImage->iframe_url) }}" placeholder="https://example.com" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="mt-1 text-sm text-gray-500">Enter the full URL of the website you want to display in the scrolling marquee.</p>
                            @error('iframe_url')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="sort_order" class="block text-gray-700 text-sm font-bold mb-2">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" value="{{ $welcomeImage->sort_order }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <p class="text-xs text-gray-500 mt-1">Lower numbers appear first in the sequence.</p>
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" class="form-checkbox" {{ $welcomeImage->is_active ? 'checked' : '' }}>
                                <span class="ml-2">Active</span>
                            </label>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Website
                            </button>
                            <a href="{{ route('admin.welcome-images.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
