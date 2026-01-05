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
                    <form action="{{ route('admin.home-page-cards.update', $circularItem) }}" method="POST" enctype="multipart/form-data" id="cardForm">
                        @csrf
                        @method('PUT')

                        {{-- Section 1: Top Thumbnails --}}
                        <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Section 1: Top Thumbnails</h3>
                            
                            {{-- Existing Thumbnails --}}
                            {{-- Existing Thumbnails (Sortable) --}}
                            @if($circularItem->section1_images && count($circularItem->section1_images) > 0)
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Current Thumbnails (Drag to Reorder)</label>
                                <div id="sortable-thumbnails" class="flex gap-2 flex-wrap p-2 border border-dashed border-gray-300 rounded bg-gray-50 min-h-[100px]">
                                    @foreach($circularItem->section1_images as $thumb)
                                    <div class="relative group cursor-move">
                                        <img src="{{ Storage::url($thumb) }}" alt="Thumbnail" class="h-24 w-24 object-cover rounded-md border shadow-sm">
                                        <input type="hidden" name="section1_existing[]" value="{{ $thumb }}">
                                        <button type="button" onclick="this.parentElement.remove()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-700 focus:outline-none opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Drag images to reorder. Click 'X' to delete on save.</p>
                            </div>
                            @endif

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Add New Thumbnail Images</label>
                                <input type="file" name="section1_images[]" accept="image/*" multiple onchange="previewImages(this)" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <div id="new-thumbnails-preview" class="flex gap-2 flex-wrap mt-2"></div>
                                <p class="text-gray-500 text-xs mt-1">Upload additional images (will be added after existing ones)</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="section1_image_width" class="block text-gray-700 text-sm font-bold mb-2">Thumbnail Width (px)</label>
                                    <input type="number" name="section1_image_width" id="section1_image_width" value="{{ old('section1_image_width', $circularItem->section1_image_width ?? 160) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <div>
                                    <label for="section1_image_height" class="block text-gray-700 text-sm font-bold mb-2">Thumbnail Height (px)</label>
                                    <input type="number" name="section1_image_height" id="section1_image_height" value="{{ old('section1_image_height', $circularItem->section1_image_height ?? 104) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                            </div>
                        </div>

                        {{-- Section 2: Main Content --}}
                        <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Section 2: Main Content</h3>
                            
                            @if($circularItem->section2_image)
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Current Main Image</label>
                                <img src="{{ Str::startsWith($circularItem->section2_image, 'http') ? $circularItem->section2_image : Storage::url($circularItem->section2_image) }}" 
                                     alt="Current" 
                                     class="h-48 w-auto object-cover rounded-md border mb-2">
                            </div>
                            @endif

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Replace Main Image (Optional)</label>
                                <input type="file" name="section2_image_file" accept="image/*" onchange="previewMainImage(this)" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2">
                                <div id="section2-image-preview" class="mb-2"></div>
                                <label for="section2_image_url" class="block text-gray-600 text-xs mb-1">Or enter new image URL</label>
                                <input type="url" name="section2_image_url" id="section2_image_url" placeholder="https://example.com/image.jpg" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <p class="text-gray-500 text-xs mt-1">Leave both empty to keep current image</p>
                            </div>

                            <div class="mb-4">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $circularItem->title) }}" placeholder="Premium Web Solutions 1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                                <textarea name="description" id="description" class="summernote shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $circularItem->description) }}</textarea>
                            </div>
                        </div>

                        {{-- Section 3: Dynamic Buttons --}}
                        <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Section 3: Buttons</h3>
                            
                            <div id="buttonsContainer" class="space-y-4 mb-4">
                                {{-- Existing buttons will be loaded here via JavaScript --}}
                            </div>
                            
                            <button type="button" onclick="addButton()" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                                + Add Button
                            </button>
                            
                            <div class="mt-6">
                                <label for="enquiry_link" class="block text-gray-700 text-sm font-bold mb-2">Enquiry Button Link</label>
                                <input type="text" name="enquiry_link" id="enquiry_link" value="{{ old('enquiry_link', $circularItem->enquiry_link) }}" placeholder="/contact or https://wa.me/1234567890" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <p class="text-gray-500 text-xs mt-1">This link will be used for the "Enquiry" button</p>
                            </div>
                        </div>

                        {{-- Color Overrides --}}
                        <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Color Overrides (Optional)</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="card_bg_color" class="block text-gray-700 text-sm font-bold mb-2">Card Background Color</label>
                                    <div class="flex gap-2 items-center">
                                        <input type="color" name="card_bg_color" id="card_bg_color" value="{{ old('card_bg_color', $circularItem->card_bg_color ?? '#ffffff') }}" class="h-10 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="text" id="card_bg_color_hex" value="{{ old('card_bg_color', $circularItem->card_bg_color ?? '#ffffff') }}" class="shadow appearance-none border rounded flex-1 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="#FFFFFF">
                                    </div>
                                </div>

                                <div>
                                    <label for="title_color" class="block text-gray-700 text-sm font-bold mb-2">Title Text Color</label>
                                    <div class="flex gap-2 items-center">
                                        <input type="color" name="title_color" id="title_color" value="{{ old('title_color', $circularItem->title_color ?? '#1a1a1a') }}" class="h-10 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="text" id="title_color_hex" value="{{ old('title_color', $circularItem->title_color ?? '#1a1a1a') }}" class="shadow appearance-none border rounded flex-1 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="#1A1A1A">
                                    </div>
                                </div>

                                <div>
                                    <label for="desc_color" class="block text-gray-700 text-sm font-bold mb-2">Description Text Color</label>
                                    <div class="flex gap-2 items-center">
                                        <input type="color" name="desc_color" id="desc_color" value="{{ old('desc_color', $circularItem->desc_color ?? '#6b7280') }}" class="h-10 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="text" id="desc_color_hex" value="{{ old('desc_color', $circularItem->desc_color ?? '#6b7280') }}" class="shadow appearance-none border rounded flex-1 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="#6B7280">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Other Settings --}}
                        <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Other Settings</h3>
                            
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
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Card
                            </button>
                            <a href="{{ route('admin.home-page-cards.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Summernote CSS/JS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        /* Override Tailwind's Preflight Reset for Summernote Content */
        .note-editable ul { list-style: disc !important; padding-left: 2rem !important; margin-bottom: 1rem !important; }
        .note-editable ul ul { list-style: circle !important; }
        .note-editable ul ul ul { list-style: square !important; }
        .note-editable ol { list-style: decimal !important; padding-left: 2rem !important; margin-bottom: 1rem !important; }
        .note-editable ol ol { list-style: lower-alpha !important; }
        .note-editable ol ol ol { list-style: lower-roman !important; }
        .note-editable li { display: list-item !important; margin-bottom: 0.25rem !important; }
        .note-editable h1 { font-size: 2.25rem !important; font-weight: 800 !important; margin-bottom: 1rem !important; line-height: 1.2 !important; }
        .note-editable h2 { font-size: 1.875rem !important; font-weight: 700 !important; margin-bottom: 0.75rem !important; line-height: 1.3 !important; }
        .note-editable h3 { font-size: 1.5rem !important; font-weight: 600 !important; margin-bottom: 0.5rem !important; line-height: 1.4 !important; }
        .note-editable h4 { font-size: 1.25rem !important; font-weight: 600 !important; margin-bottom: 0.5rem !important; }
        .note-editable h5 { font-size: 1.125rem !important; font-weight: 600 !important; margin-bottom: 0.5rem !important; }
        .note-editable h6 { font-size: 1rem !important; font-weight: 600 !important; margin-bottom: 0.5rem !important; }
        .note-editable p { margin-bottom: 1rem !important; }
        
        /* Fix Layout & Z-Index Issues */
        .note-editor.note-frame.fullscreen {
            z-index: 999999 !important;
            background-color: white !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
        }
        .note-modal { z-index: 1000000 !important; }
        .note-modal-backdrop { z-index: 999999 !important; }
        .note-toolbar { z-index: 50 !important; position: relative; }
        .dropdown-menu { z-index: 1000001 !important; }
        .note-btn.active, .note-btn:active {
            background-color: #d1d5db !important;
            color: black !important;
            border: 1px solid #9ca3af !important;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

    <script>
        // Main Image Preview (Section 2)
        function previewMainImage(input) {
            const preview = document.getElementById('section2-image-preview');
            preview.innerHTML = '';
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('h-48', 'w-auto', 'object-cover', 'rounded-md', 'border');
                    preview.appendChild(img);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Image Preview Function
        function previewImages(input) {
            const preview = document.getElementById('new-thumbnails-preview');
            preview.innerHTML = '';
            
            if (input.files) {
                Array.from(input.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('h-24', 'w-24', 'object-cover', 'rounded-md', 'border', 'shadow-sm');
                        preview.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }

        // Initialize Sortable
        document.addEventListener('DOMContentLoaded', function() {
            const el = document.getElementById('sortable-thumbnails');
            if (el) {
                new Sortable(el, {
                    animation: 150,
                    ghostClass: 'bg-blue-100'
                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Start writing your content here...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear', 'strikethrough', 'superscript', 'subscript']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>

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

        // Load existing buttons
        const existingButtons = @json($circularItem->buttons ?? []);
        
        function addButton(text = '', link = '', bgColor = '#111827', textColor = '#ffffff') {
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
                        <input type="text" name="buttons[${buttonIndex}][text]" value="${text}" placeholder="Demo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 text-sm leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div>
                        <label class="block text-gray-600 text-xs font-bold mb-1">Link</label>
                        <input type="text" name="buttons[${buttonIndex}][link]" value="${link}" placeholder="/demo or #" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 text-sm leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-600 text-xs font-bold mb-1">Background Color</label>
                        <div class="flex gap-2 items-center">
                            <input type="color" name="buttons[${buttonIndex}][bg_color]" value="${bgColor}" class="h-8 w-16 rounded border border-gray-300 cursor-pointer">
                            <span class="text-xs text-gray-500">${bgColor}</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-600 text-xs font-bold mb-1">Text Color</label>
                        <div class="flex gap-2 items-center">
                            <input type="color" name="buttons[${buttonIndex}][text_color]" value="${textColor}" class="h-8 w-16 rounded border border-gray-300 cursor-pointer">
                            <span class="text-xs text-gray-500">${textColor}</span>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(buttonDiv);
            buttonIndex++;
        }

        // Load existing buttons on page load
        if (existingButtons && existingButtons.length > 0) {
            existingButtons.forEach(button => {
                addButton(button.text || '', button.link || '', button.bg_color || '#111827', button.text_color || '#ffffff');
            });
        } else {
            // Add one empty button if no existing buttons
            addButton();
        }
    </script>
</x-app-layout>
