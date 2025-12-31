<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Marquee Image') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.welcome-images.update', $welcomeImage) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Current Image</label>
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $welcomeImage->image_path) }}" alt="Current Image" class="h-32 object-contain rounded border p-1">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700">Replace Image (Optional)</label>
                            <input type="file" name="image" id="image" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                    <label for="sort_order" class="block text-gray-700 text-sm font-bold mb-2">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ $welcomeImage->sort_order }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="target_url" class="block text-gray-700 text-sm font-bold mb-2">Target URL (Optional)</label>
                    <input type="url" name="target_url" id="target_url" value="{{ $welcomeImage->target_url }}" placeholder="https://example.com" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="opacity" class="block text-gray-700 text-sm font-bold mb-2">Opacity (%)</label>
                    <input type="number" name="opacity" id="opacity" value="{{ $welcomeImage->opacity ?? 100 }}" min="0" max="100" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <p class="text-xs text-gray-500 mt-1">0 = Invisible, 100 = Fully Visible</p>
                </div>

                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" class="form-checkbox" {{ $welcomeImage->is_active ? 'checked' : '' }}>
                        <span class="ml-2">Active</span>
                    </label>
                </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Image
                            </button>
                            <a href="{{ route('admin.welcome-images.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
