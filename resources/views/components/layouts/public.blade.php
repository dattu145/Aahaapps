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
    @livewireStyles
</head>
<body class="antialiased bg-gray-50 text-gray-900 font-sans selection:bg-indigo-100 selection:text-indigo-700" x-data="{ sidebarOpen: false }">

    <!-- DESKTOP TOP NAVIGATION -->
    <!-- Fixed top, visible on lg -->
    <header class="hidden lg:flex fixed top-0 w-full h-20 bg-white/80 backdrop-blur-md border-b border-gray-100 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex items-center justify-between">
            
            <!-- Logo Area -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                @if(isset($globalSettings['logo']) && $globalSettings['logo'])
                    <img src="{{ asset('storage/' . $globalSettings['logo']) }}" alt="Logo" class="object-contain transition-transform duration-300 group-hover:scale-105" style="height: {{ $globalSettings['logo_height'] ?? '40' }}px; width: {{ $globalSettings['logo_width'] ?? 'auto' }};">
                @elseif(isset($globalSettings['logo_url']) && $globalSettings['logo_url'])
                    <img src="{{ $globalSettings['logo_url'] }}" alt="Logo" class="object-contain transition-transform duration-300 group-hover:scale-105" style="height: {{ $globalSettings['logo_height'] ?? '40' }}px; width: {{ $globalSettings['logo_width'] ?? 'auto' }};">
                @else
                    <span class="font-bold text-2xl text-indigo-600 tracking-tight">{{ config('app.name') }}</span>
                @endif
            </a>

            <!-- Desktop Menu Links -->
            <nav class="flex items-center space-x-8">
                @foreach($globalMenu as $item)
                    <a href="{{ $item->url }}" wire:navigate
                       class="text-sm font-medium transition-all duration-200 hover:text-indigo-600 relative group py-2
                       {{ request()->fullUrlIs($item->url) || request()->is(ltrim($item->url, '/')) ? 'text-indigo-600' : 'text-gray-600' }}">
                        {{ $item->label }}
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-indigo-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left {{ request()->fullUrlIs($item->url) || request()->is(ltrim($item->url, '/')) ? 'scale-x-100' : '' }}"></span>
                    </a>
                @endforeach
                
                <!-- Optional CTA Button -->
                @if(isset($globalSettings['whatsapp_number']))
                    <a href="https://wa.me/{{ $globalSettings['whatsapp_number'] }}" target="_blank" class="ml-4 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-full shadow-lg hover:shadow-indigo-500/30 transition-all duration-300 transform hover:-translate-y-0.5">
                        Get Started
                    </a>
                @endif
            </nav>
        </div>
    </header>

    <!-- TABLET/MOBILE TOP HEADER -->
    <!-- Visible on mobile/tablet only (hidden on lg if desired, or adjust breakpoints) -->
    <!-- Since user said "remove left menu and add to top", and "tab view hamburger", we treat lg as desktop breakpoint -->
    <header class="lg:hidden fixed top-0 w-full h-16 bg-white/90 backdrop-blur-md border-b border-gray-200 z-40 flex items-center justify-between px-4 sm:px-6">
        <!-- Logo -->
        <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2">
           @if(isset($globalSettings['logo']) && $globalSettings['logo'])
                <img src="{{ asset('storage/' . $globalSettings['logo']) }}" alt="Logo" class="object-contain" style="height: {{ $globalSettings['logo_height'] ?? '32' }}px; width: {{ $globalSettings['logo_width'] ?? 'auto' }};">
            @elseif(isset($globalSettings['logo_url']) && $globalSettings['logo_url'])
                <img src="{{ $globalSettings['logo_url'] }}" alt="Logo" class="object-contain" style="height: {{ $globalSettings['logo_height'] ?? '32' }}px; width: {{ $globalSettings['logo_width'] ?? 'auto' }};">
            @else
                <span class="font-bold text-xl text-indigo-600">{{ config('app.name') }}</span>
            @endif
        </a>

        <!-- Hamburger Button (Right aligned) -->
        <button @click="sidebarOpen = true" class="p-2 -mr-2 text-gray-600 hover:text-indigo-600 focus:outline-none transition-colors duration-200">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </header>

    <!-- RIGHT SLIDE-OVER DRAWER (Mobile/Tablet) -->
    <!-- Simplified structure for reliability -->
    <div class="relative z-50 lg:hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true" 
         x-show="sidebarOpen" 
         style="display: none;">
         
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
             x-show="sidebarOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"></div>

        <!-- Panel -->
        <div class="fixed inset-y-0 right-0 z-50 w-full max-w-xs bg-white shadow-2xl transform transition-transform"
             x-show="sidebarOpen"
             x-transition:enter="transform transition ease-in-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transform transition ease-in-out duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full">
            
             <div class="h-full flex flex-col overflow-y-scroll py-6 bg-white shadow-xl">
                <div class="px-4 sm:px-6 border-b border-gray-100 pb-4 flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Menu</h2>
                    <button type="button" class="rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500" @click="sidebarOpen = false">
                        <span class="sr-only">Close panel</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mt-6 relative flex-1 px-4 sm:px-6">
                    <nav class="flex flex-col space-y-4">
                        @foreach($globalMenu as $item)
                            <a href="{{ $item->url }}" wire:navigate
                               class="group flex items-center px-4 py-3 text-base font-medium rounded-xl transition-all duration-200
                               {{ request()->fullUrlIs($item->url) || request()->is(ltrim($item->url, '/')) ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                                {{ $item->label }}
                                <span class="ml-auto opacity-0 group-hover:opacity-100 text-indigo-400 transition-opacity">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </span>
                            </a>
                        @endforeach
                    </nav>
                    
                    @if(isset($globalSettings['whatsapp_number']))
                        <div class="mt-8 px-4">
                            <a href="https://wa.me/{{ $globalSettings['whatsapp_number'] }}" target="_blank" class="flex items-center justify-center w-full px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-200 transition-all duration-300">
                                Contact Us
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT WRAPPER -->
    <!-- Left margin removed (lg:ml-64 removed). Top padding adjusted for fixed header -->
    <main class="min-h-screen pt-16 lg:pt-20 bg-gray-50 transition-all duration-300">
        {{ $slot }}
    </main>

    <!-- MOBILE BOTTOM NAVBAR -->
    <!-- Kept as requested -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-white/90 backdrop-blur-xl border-t border-gray-200 z-40 flex items-center justify-around pb-safe shadow-[0_-4px_20px_-5px_rgba(0,0,0,0.1)]">
        @foreach($globalMenu->take(4) as $item)
            <a href="{{ $item->url }}" wire:navigate class="group flex flex-col items-center justify-center w-full h-full space-y-1 relative
               {{ request()->fullUrlIs($item->url) || request()->is(ltrim($item->url, '/')) ? 'text-indigo-600' : 'text-gray-400 hover:text-gray-600' }}">
                
                {{-- Active Indicator Line --}}
                @if(request()->fullUrlIs($item->url) || request()->is(ltrim($item->url, '/')))
                    <span class="absolute top-0 left-1/2 transform -translate-x-1/2 w-8 h-0.5 bg-indigo-600 rounded-full"></span>
                @endif

                <div class="w-6 h-6 rounded-full flex items-center justify-center transition-all duration-300 group-hover:-translate-y-1">
                     {{-- Simple Icon Logic (First Char) - Replace with actual icons later if needed --}}
                    <span class="text-sm font-bold uppercase">{{ substr($item->label, 0, 1) }}</span>
                </div>
                <span class="text-[10px] font-medium tracking-wide">{{ $item->label }}</span>
            </a>
        @endforeach
    </nav>

    @livewireScripts
</body>
</html>
