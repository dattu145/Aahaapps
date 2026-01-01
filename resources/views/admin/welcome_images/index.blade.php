<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Scrolling Websites') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Global Settings -->
                    <div class="mb-8 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="font-semibold text-gray-700 mb-3">Animation & Display Settings</h3>
                        <form action="{{ route('admin.welcome-images.settings') }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Animation Duration -->
                                <div>
                                    <label for="marquee_speed" class="block text-sm font-medium text-gray-700 mb-1">Duration (Seconds)</label>
                                    <input type="number" name="marquee_speed" id="marquee_speed" value="{{ $marquee_speed }}" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <p class="mt-1 text-xs text-gray-500">Lower = Faster, Higher = Slower (5-200)</p>
                                </div>

                                <!-- Iframe Width -->
                                <div>
                                    <label for="iframe_width" class="block text-sm font-medium text-gray-700 mb-1">Iframe Width</label>
                                    <input type="text" name="iframe_width" id="iframe_width" value="{{ $iframe_width }}" 
                                           placeholder="220px" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <p class="mt-1 text-xs text-gray-500">e.g., 220px, 30%, 15vw</p>
                                </div>

                                <!-- Iframe Height -->
                                <div>
                                    <label for="iframe_height" class="block text-sm font-medium text-gray-700 mb-1">Iframe Height</label>
                                    <input type="text" name="iframe_height" id="iframe_height" value="{{ $iframe_height }}" 
                                           placeholder="100vh" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <p class="mt-1 text-xs text-gray-500">e.g., 100vh, 800px, 50%</p>
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none transition ease-in-out duration-150">
                                    Save Settings
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="flex justify-between items-center mb-4">
                        <a href="{{ route('admin.welcome-images.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Add Website
                        </a>
                    </div>
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Website URL</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Active</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($images as $image)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-12 w-12 flex-shrink-0 bg-indigo-100 flex items-center justify-center rounded border border-indigo-200">
                                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Website</div>
                                                <div class="text-xs text-gray-500 truncate max-w-md" title="{{ $image->iframe_url }}">
                                                    {{ $image->iframe_url }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $image->sort_order }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $image->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $image->is_active ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.welcome-images.edit', $image) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        
                                        <form action="{{ route('admin.welcome-images.destroy', $image) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this website?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        No websites found. Add website URLs to display in the scrolling marquee.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
