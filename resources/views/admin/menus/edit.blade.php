<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Menu Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.menus.update', $menu) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Label</label>
                            <input type="text" name="label" class="mt-1 block w-full rounded-md shadow-sm border-gray-300" value="{{ old('label', $menu->label) }}" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">URL</label>
                            <input type="text" name="url" class="mt-1 block w-full rounded-md shadow-sm border-gray-300" value="{{ old('url', $menu->url) }}" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Order</label>
                            <input type="number" name="order" class="mt-1 block w-full rounded-md shadow-sm border-gray-300" value="{{ old('order', $menu->order) }}">
                        </div>
                        <div class="mb-4">
                             <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" value="1" {{ $menu->is_active ? 'checked' : '' }}>
                                <span class="ml-2">Active</span>
                            </label>
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                            
                            <!-- Delete Button -->
                             <button type="button" onclick="document.getElementById('delete-form').submit()" class="text-red-600 hover:text-red-900 underline">Delete</button>
                        </div>
                    </form>
                    
                    <form id="delete-form" method="POST" action="{{ route('admin.menus.destroy', $menu) }}" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
