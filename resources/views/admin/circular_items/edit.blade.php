<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Home Page Card') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.circular-items.update', $circularItem) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $circularItem->title) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="3">{{ old('description', $circularItem->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="button_text" class="block text-gray-700 text-sm font-bold mb-2">Button Text</label>
                            <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $circularItem->button_text) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label for="link" class="block text-gray-700 text-sm font-bold mb-2">Link</label>
                            <input type="text" name="link" id="link" value="{{ old('link', $circularItem->link) }}" placeholder="e.g., /erp or https://example.com" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label for="color" class="block text-gray-700 text-sm font-bold mb-2">Card Color (Optional)</label>
                            <div class="flex gap-2 items-center">
                                <input type="color" name="color" id="color" value="{{ old('color', $circularItem->color ?? '#ffffff') }}" class="h-10 w-20 rounded border border-gray-300 cursor-pointer">
                                <input type="text" id="color_hex" value="{{ old('color', $circularItem->color ?? '#ffffff') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="#FFFFFF">
                            </div>
                            <p class="text-gray-500 text-xs mt-1">Choose a color for this card or leave default</p>
                        </div>

                        <div class="mb-4">
                            <label for="text_color" class="block text-gray-700 text-sm font-bold mb-2">Text Color (Optional)</label>
                            <div class="flex gap-2 items-center">
                                <input type="color" name="text_color" id="text_color" value="{{ old('text_color', $circularItem->text_color ?? '#1a1a1a') }}" class="h-10 w-20 rounded border border-gray-300 cursor-pointer">
                                <input type="text" id="text_color_hex" value="{{ old('text_color', $circularItem->text_color ?? '#1a1a1a') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="#1A1A1A">
                            </div>
                            <p class="text-gray-500 text-xs mt-1">Choose text color for title, description, button</p>
                        </div>

                        <div class="mb-4">
                            <label for="sort_order" class="block text-gray-700 text-sm font-bold mb-2">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $circularItem->sort_order) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ $circularItem->is_active ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Active</span>
                            </label>
                        </div>

                        <script>
                            const colorPicker = document.getElementById('color');
                            const colorHex = document.getElementById('color_hex');
                            
                            colorPicker.addEventListener('input', (e) => {
                                colorHex.value = e.target.value;
                            });
                            
                            colorHex.addEventListener('input', (e) => {
                                if (e.target.value.match(/^#[0-9A-F]{6}$/i)) {
                                    colorPicker.value = e.target.value;
                                }
                            });
                            
                            // Text color picker sync
                            const textColorPicker = document.getElementById('text_color');
                            const textColorHex = document.getElementById('text_color_hex');
                            
                            textColorPicker.addEventListener('input', (e) => {
                                textColorHex.value = e.target.value;
                            });
                            
                            textColorHex.addEventListener('input', (e) => {
                                if (e.target.value.match(/^#[0-9A-F]{6}$/i)) {
                                    textColorPicker.value = e.target.value;
                                }
                            });
                        </script>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Item
                            </button>
                            <a href="{{ route('admin.circular-items.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
