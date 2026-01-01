<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" class="mt-1 block w-full rounded-md shadow-sm border-gray-300" value="{{ old('title', $page->title) }}" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Content</label>
                            <textarea name="content" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 h-64">{{ old('content', $page->content) }}</textarea>
                        </div>
                        <div class="mb-4">
                             <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" value="1" {{ $page->is_active ? 'checked' : '' }}>
                                <span class="ml-2">Active</span>
                            </label>
                        </div>
                         <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                             <button type="button" onclick="document.getElementById('delete-form').submit()" class="text-red-600 hover:text-red-900 underline">Delete</button>
                        </div>
                    </form>
                    
                     <form id="delete-form" method="POST" action="{{ route('admin.pages.destroy', $page) }}" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Summernote CSS/JS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        /* Override Tailwind's Preflight Reset for Summernote Content */
        /* Unordered Lists & Nesting */
        .note-editable ul { list-style: disc !important; padding-left: 2rem !important; margin-bottom: 1rem !important; }
        .note-editable ul ul { list-style: circle !important; }
        .note-editable ul ul ul { list-style: square !important; }

        /* Ordered Lists & Nesting */
        .note-editable ol { list-style: decimal !important; padding-left: 2rem !important; margin-bottom: 1rem !important; }
        .note-editable ol ol { list-style: lower-alpha !important; }
        .note-editable ol ol ol { list-style: lower-roman !important; }

        /* Ensure List Items behave correctly */
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
            z-index: 999999 !important; /* Must be extremely high to cover admin nav */
            background-color: white !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
        }
        
        /* Fix Modal Z-Index (Image/Video Dialogs) */
        .note-modal {
            z-index: 1000000 !important; /* Above fullscreen editor */
        }
        .note-modal-backdrop {
            z-index: 999999 !important;
        }
        
        /* Toolbar adjustments */
        .note-toolbar {
            z-index: 50 !important;
            position: relative;
        }
        
        /* Dropdown menu fix */
        .dropdown-menu {
            z-index: 1000001 !important;
        }
        
        /* Fix Active Button State (Tailwind resets button styles) */
        .note-btn.active, .note-btn:active {
            background-color: #d1d5db !important; /* gray-300 */
            color: black !important;
            border: 1px solid #9ca3af !important;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {
            $('textarea[name="content"]').summernote({
                placeholder: 'Start editing your content here...',
                tabsize: 2,
                height: 400,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear', 'strikethrough', 'superscript', 'subscript']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help', 'undo', 'redo']]
                ]
            });
        });
    </script>
</x-app-layout>
