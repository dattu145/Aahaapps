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
                    <form method="POST" action="{{ route('admin.pages.update', $page) }}">
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
</x-app-layout>
