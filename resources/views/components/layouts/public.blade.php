<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($page) ? $page->title : config('app.name') }}</title>
    @if(isset($page) && $page->meta_description)
        <meta name="description" content="{{ $page->meta_description }}">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900 font-sans" x-data="{ sidebarOpen: false, mobileMenuOpen: false }">

    <!-- DESKTOP SIDEBAR (Left) -->
    <!-- Hidden on mobile (sm), visible on lg -->
    <aside class="hidden lg:flex flex-col w-64 h-screen fixed inset-y-0 left-0 bg-white border-r border-gray-200 z-30 transition-transform duration-300">
        <!-- Logo Area -->
        <div class="h-16 flex items-center justify-center border-b border-gray-100 px-6">
            @if(isset($globalSettings['logo']) && $globalSettings['logo'])
                <img src="{{ asset('storage/' . $globalSettings['logo']) }}" alt="Logo" class="h-10 w-auto">
            @else
                <span class="font-bold text-xl text-indigo-600">{{ config('app.name') }}</span>
            @endif
        </div>

        <!-- Desktop Navigation Links -->
        <nav class="flex-1 overflow-y-auto py-4 px-4 space-y-2">
            @foreach($globalMenu as $item)
                <a href="{{ $item->url }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors group
                   {{ request()->fullUrlIs($item->url) || request()->is(ltrim($item->url, '/')) ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <!-- Icon placeholder (could add icon field to DB later) -->
                    <span class="w-2 h-2 rounded-full mr-3 {{ request()->fullUrlIs($item->url) || request()->is(ltrim($item->url, '/')) ? 'bg-indigo-600' : 'bg-gray-300 group-hover:bg-gray-400' }}"></span>
                    {{ $item->label }}
                </a>
            @endforeach
        </nav>

        <!-- Footer / Optional -->
        <div class="p-4 border-t border-gray-100 text-xs text-gray-400 text-center">
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </div>
    </aside>

    <!-- MOBILE HEADER (Top) -->
    <!-- Visible on mobile only -->
    <header class="lg:hidden fixed top-0 left-0 right-0 h-16 bg-white border-b border-gray-200 z-40 flex items-center justify-between px-4">
        <div class="flex items-center">
            @if(isset($globalSettings['logo']) && $globalSettings['logo'])
                <img src="{{ asset('storage/' . $globalSettings['logo']) }}" alt="Logo" class="h-8 w-auto">
            @else
                <span class="font-bold text-xl text-indigo-600">{{ config('app.name') }}</span>
            @endif
        </div>
        <button @click="mobileMenuOpen = true" class="p-2 text-gray-600 hover:text-indigo-600 focus:outline-none">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </header>

    <!-- MOBILE FULL SCREEN OVERLAY -->
    <div x-show="mobileMenuOpen" 
         style="display: none;"
         class="fixed inset-0 z-50 bg-white flex flex-col p-6 animate-fade-in-up"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4">
         
        <div class="flex items-center justify-between mb-8">
            <span class="font-bold text-2xl text-indigo-600">Menu</span>
            <button @click="mobileMenuOpen = false" class="p-2 text-gray-500 hover:text-gray-900">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <nav class="flex flex-col space-y-4">
            @foreach($globalMenu as $item)
                <a href="{{ $item->url }}" 
                   class="text-xl font-medium px-4 py-3 rounded-lg
                   {{ request()->fullUrlIs($item->url) || request()->is(ltrim($item->url, '/')) ? 'text-indigo-600 bg-indigo-50' : 'text-gray-800' }}">
                    {{ $item->label }}
                </a>
            @endforeach
        </nav>
    </div>

    <!-- MAIN CONTENT WRAPPER -->
    <!-- Add left margin on desktop to maintain space for sidebar, padding top on mobile for header -->
    <main class="lg:ml-64 min-h-screen pt-16 lg:pt-0 bg-gray-50 transition-all duration-300">
        {{ $slot }}
    </main>

    <!-- MOBILE BOTTOM NAVBAR -->
    <!-- Fixed bottom, visible on mobile -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-gray-200 z-40 flex items-center justify-around pb-safe">
        <!-- Display first 4 items or specific ones logic later. For now, showing up to 4 items. -->
        @foreach($globalMenu->take(4) as $item)
            <a href="{{ $item->url }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->fullUrlIs($item->url) || request()->is(ltrim($item->url, '/')) ? 'text-indigo-600' : 'text-gray-400 hover:text-gray-600' }}">
                <!-- Placeholder Icons based on label first char or random -->
                <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center {{ request()->fullUrlIs($item->url) || request()->is(ltrim($item->url, '/')) ? 'border-indigo-600' : 'border-gray-300' }} text-xs font-bold uppercase">
                    {{ substr($item->label, 0, 1) }}
                </div>
                <span class="text-[10px] font-medium">{{ $item->label }}</span>
            </a>
        @endforeach
    </nav>

</body>
</html>
