<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Home Page Card') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.circular-items.store') }}" method="POST" enctype="multipart/form-data" id="cardForm">
                        @csrf

                        {{-- Section 1: Top Thumbnails --}}
                        <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Section 1: Top Thumbnails</h3>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Thumbnail Images (Multiple)</label>
                                <div id="thumbnailsContainer" class="space-y-2">
                                    <input type="file" name="section1_images[]" accept="image/*" multiple class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <p class="text-gray-500 text-xs mt-1">Upload multiple images for the top thumbnail section</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="section1_image_width" class="block text-gray-700 text-sm font-bold mb-2">Thumbnail Width (px)</label>
                                    <input type="number" name="section1_image_width" id="section1_image_width" value="160" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <div>
                                    <label for="section1_image_height" class="block text-gray-700 text-sm font-bold mb-2">Thumbnail Height (px)</label>
                                    <input type="number" name="section1_image_height" id="section1_image_height" value="104" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                            </div>
                        </div>

                        {{-- Section 2: Main Content --}}
                        <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Section 2: Main Content</h3>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Main Image</label>
                                <input type="file" name="section2_image_file" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2">
                                <label for="section2_image_url" class="block text-gray-600 text-xs mb-1">Or enter image URL</label>
                                <input type="url" name="section2_image_url" id="section2_image_url" placeholder="https://example.com/image.jpg" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                                <input type="text" name="title" id="title" placeholder="Premium Web Solutions 1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                                <textarea name="description" id="description" rows="3" placeholder="Tailored, high-performance web applications built for scale." class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                        </div>

                        {{-- Section 3: Dynamic Buttons --}}
                        <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Section 3: Buttons</h3>
                            
                            <div id="buttonsContainer" class="space-y-4 mb-4">
                                {{-- Buttons will be added dynamically here --}}
                            </div>
                            
                            <button type="button" onclick="addButton()" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                                + Add Button
                            </button>
                            
                            <div class="mt-6">
                                <label for="enquiry_link" class="block text-gray-700 text-sm font-bold mb-2">Enquiry Button Link</label>
                                <input type="text" name="enquiry_link" id="enquiry_link" placeholder="/contact or https://wa.me/1234567890" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <p class="text-gray-500 text-xs mt-1">This link will be used for the "Enquiry" button (common for all cards)</p>
                            </div>
                        </div>

                        {{-- Color Overrides --}}
                        <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Color Overrides (Optional)</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="card_bg_color" class="block text-gray-700 text-sm font-bold mb-2">Card Background Color</label>
                                    <div class="flex gap-2 items-center">
                                        <input type="color" name="card_bg_color" id="card_bg_color" class="h-10 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="text" id="card_bg_color_hex" value="#ffffff" class="shadow appearance-none border rounded flex-1 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="#FFFFFF">
                                    </div>
                                    <p class="text-gray-500 text-xs mt-1">Override global card background</p>
                                </div>

                                <div>
                                    <label for="title_color" class="block text-gray-700 text-sm font-bold mb-2">Title Text Color</label>
                                    <div class="flex gap-2 items-center">
                                        <input type="color" name="title_color" id="title_color" class="h-10 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="text" id="title_color_hex" value="#1a1a1a" class="shadow appearance-none border rounded flex-1 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="#1A1A1A">
                                    </div>
                                    <p class="text-gray-500 text-xs mt-1">Override global title color</p>
                                </div>

                                <div>
                                    <label for="desc_color" class="block text-gray-700 text-sm font-bold mb-2">Description Text Color</label>
                                    <div class="flex gap-2 items-center">
                                        <input type="color" name="desc_color" id="desc_color" class="h-10 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="text" id="desc_color_hex" value="#6b7280" class="shadow appearance-none border rounded flex-1 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="#6B7280">
                                    </div>
                                    <p class="text-gray-500 text-xs mt-1">Override global description color</p>
                                </div>
                            </div>
                        </div>

                        {{-- Other Settings --}}
                        <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Other Settings</h3>
                            
                            <div class="mb-4">
                                <label for="sort_order" class="block text-gray-700 text-sm font-bold mb-2">Sort Order</label>
                                <input type="number" name="sort_order" id="sort_order" value="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" checked>
                                    <span class="ml-2 text-gray-700">Active</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Create Card
                            </button>
                            <a href="{{ route('admin.circular-items.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Color picker sync functions
        function syncColorPicker(pickerId, hexId) {
            const picker = document.getElementById(pickerId);
            const hex = document.getElementById(hexId);
            
            picker.addEventListener('input', (e) => {
                hex.value = e.target.value;
            });
            
            hex.addEventListener('input', (e) => {
                if (e.target.value.match(/^#[0-9A-F]{6}$/i)) {
                    picker.value = e.target.value;
                }
            });
        }

        syncColorPicker('card_bg_color', 'card_bg_color_hex');
        syncColorPicker('title_color', 'title_color_hex');
        syncColorPicker('desc_color', 'desc_color_hex');

        // Dynamic button management
        let buttonIndex = 0;

        function addButton() {
            const container = document.getElementById('buttonsContainer');
            const buttonDiv = document.createElement('div');
            buttonDiv.classList.add('p-4', 'border', 'rounded-lg', 'bg-white');
            buttonDiv.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <h4 class="font-semibold text-gray-700">Button ${buttonIndex + 1}</h4>
                    <button type="button" onclick="this.closest('div').parentElement.remove()" class="text-red-600 hover:text-red-800 text-sm">Remove</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-600 text-xs font-bold mb-1">Button Text</label>
                        <input type="text" name="buttons[${buttonIndex}][text]" placeholder="Demo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 text-sm leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div>
                        <label class="block text-gray-600 text-xs font-bold mb-1">Link</label>
                        <input type="text" name="buttons[${buttonIndex}][link]" placeholder="/demo or #" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 text-sm leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-600 text-xs font-bold mb-1">Background Color</label>
                        <div class="flex gap-2 items-center">
                            <input type="color" name="buttons[${buttonIndex}][bg_color]" value="#111827" class="h-8 w-16 rounded border border-gray-300 cursor-pointer">
                            <span class="text-xs text-gray-500">#111827</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-600 text-xs font-bold mb-1">Text Color</label>
                        <div class="flex gap-2 items-center">
                            <input type="color" name="buttons[${buttonIndex}][text_color]" value="#ffffff" class="h-8 w-16 rounded border border-gray-300 cursor-pointer">
                            <span class="text-xs text-gray-500">#FFFFFF</span>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(buttonDiv);
            buttonIndex++;
        }

        // Add one initial button
        addButton();
    </script>
</x-app-layout>
