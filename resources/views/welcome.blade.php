<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <style>
        @keyframes fade-in-up {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fade-in-up 1s ease-out forwards;
        }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-500 { animation-delay: 0.5s; }

        /* Glassmorphism for cards */
        .glass-panel {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Enhanced Menu Animation Styles - Two-Stage Animation */
        /* Stage 0: Collapsed */
        .menu-collapsed {
            width: 680px; /* Increased from 600px for better spacing */
            max-height: 50px;
            transition: width 1s cubic-bezier(0.5, 1.2, 0.64, 1),
                        max-height 1s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Stage 1: Expanding Horizontally (1s duration, height stays same) */
        .menu-expanding-horizontal {
            width: calc(100vw - 6rem);
            max-width: 1400px;
            max-height: 50px; /* SAME as collapsed - no vertical expansion yet! */
            transition: width 1s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Stage 2: Expanded (height increases after 2s delay: 1s horizontal + 1s pause) */
        .menu-expanded {
            width: calc(100vw - 6rem);
            max-width: 1400px;
            max-height: 900px; /* NOW it expands vertically */
            transition: max-height 1s cubic-bezier(0.14, 0.10, 1.65, 5) 2s; /* 2s delay = 1s horizontal + 1s pause */
        }

        .menu-content-hidden {
            opacity: 0;
            transform: translateY(-20px); /* Reduced from -20px */
            pointer-events: none;
            transition: opacity 0.3s ease-out, transform 0.3s ease-out;
        }

        .menu-content-visible {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
            transition: opacity 0.4s ease-out 0.3s, transform 0.4s ease-out 0.3s; /* Faster: 0.4s transition, 0.8s delay */
        }

        /* Smooth hover transitions */
        .menu-item-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .menu-item-hover:hover {
            transform: translateX(4px);
        }
        
        /* HORIZONTAL CAROUSEL STYLES - INFINITE LOOP AT BOTTOM */
        /* HORIZONTAL CAROUSEL STYLES - INFINITE LOOP AT BOTTOM */
        .horizontal-carousel-wrapper {
            position: fixed;
            bottom: 0; /* Remove margin as requested */
            left: 0;
            width: 100%;
            height: calc({{ \App\Models\Setting::get('card_height', 200) }}px + 60px);
            z-index: 30;
            overflow: hidden;
            background: transparent; /* Remove background */
            pointer-events: auto;
        }
        
        /* Mobile Only (< 768px) where bottom nav exists */
        @media (max-width: 767px) {
            .horizontal-carousel-wrapper {
                bottom: 80px; /* Space for mobile bottom nav (64px + 16px buffer) */
                height: 200px;
            }
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
            background: #000;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        
        @media (max-width: 768px) {
            body {
                /* No extra padding needed on body */
            }
        }
        .horizontal-carousel-track {
            display: flex;
            gap: 20px;
            position: absolute;
            bottom: 20px;
            left: 0;
            will-change: transform;
            cursor: grab;
            padding: 0 20px;
        }
        
        .horizontal-carousel-track:active {
            cursor: grabbing;
        }

        .carousel-card {
            flex-shrink: 0;
            width: {{ \App\Models\Setting::get('card_width', 280) }}px;
            height: {{ \App\Models\Setting::get('card_height', 200) }}px;
            background: rgba(255, 255, 255, 0.95); /* Default white background */
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: {{ \App\Models\Setting::get('card_border_radius', 16) }}px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(0,0,0,0.4);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            position: relative;
            z-index: 1;
            isolation: isolate;
        }
        
        @media (max-width: 768px) {
            .carousel-card {
                width: clamp(180px, 45vw, 220px); /* Responsive width */
                height: clamp(120px, 30vw, 160px); /* Responsive height */
                padding: 12px;
                font-size: 0.85rem;
            }
            
            .carousel-card h3 {
                font-size: 0.9rem !important;
                margin-bottom: 0.25rem !important;
            }
            
            .carousel-card p {
                font-size: 0.7rem !important;
            }
            
            .carousel-card .explore-btn {
                font-size: 0.6rem !important;
                padding: 0.25rem 0.75rem !important;
            }
        }
        
        @media (max-width: 480px) {
            .carousel-card {
                width: clamp(160px, 50vw, 200px);
                height: clamp(110px, 35vw, 140px);
                padding: 10px;
            }
        }
        
        .carousel-card::before {
            content: '';
            position: absolute;
            inset: 0;
            z-index: -1;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            transition: all 0.3s ease;
        }

        .carousel-card:hover {
            transform: translateY(-10px) scale(1.05);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 16px 40px rgba(0,0,0,0.6);
        }
        
        /* Explore button hover styles */
        .carousel-card .explore-btn {
            transition: all 0.3s ease;
        }
        
        .carousel-card .explore-btn:hover {
            background-color: #000 !important;
            color: #fff !important;
            border-color: #000 !important;
        }

        #hero {
            position: relative;
            overflow: hidden;
            height: 100vh;
            /* Reserve space for bottom carousel: card_height + 60px (wrapper) + 20px (offset) + buffer */
            /* Reduced buffer since we moved carousel down (was 240px offset, now lower) */
            padding-bottom: calc({{ \App\Models\Setting::get('card_height', 200) }}px + 180px);
            box-sizing: border-box; 
        }
        
        @media (max-width: 767px) {
            #hero {
                /* Mobile: needs more space due to higher carousel position */
                padding-bottom: 300px;
            }
        }

        /* Scroll Lock Utility */
        .no-scroll {
            overflow: hidden;
            height: 100vh;
        }


    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-900 font-sans selection:bg-indigo-100 selection:text-indigo-700 overflow-hidden" 
      id="main-body"
      x-data="{ 
          menuOpen: false, 
          menuState: 'collapsed',
          sidebarOpen: false,
          toggleMenu() {
              if (!this.menuOpen) {
                  this.menuOpen = true;
                  this.menuState = 'expanding-horizontal';
                  setTimeout(() => { this.menuState = 'expanded'; }, 50);
              } else {
                  this.menuOpen = false;
                  this.menuState = 'collapsed';
              }
          }
      }">

    <!-- DESKTOP ANIMATED MENU (lg and above only) -->
    <div class="hidden lg:block">
        <!-- Menu Container -->
        <div class="absolute top-8 left-1/2 transform -translate-x-1/2 z-[9999]"
             style="z-index: 9999;"
             @click.outside="if (menuOpen) toggleMenu()"
             :class="{
                 'menu-collapsed': menuState === 'collapsed',
                 'menu-expanding-horizontal': menuState === 'expanding-horizontal',
                 'menu-expanded': menuState === 'expanded'
             }">
            
            <!-- Menu Bar -->
            <div class="bg-white shadow-2xl border border-gray-200 transition-all duration-700 ease-out"
                 :class="menuOpen ? 'rounded-2xl' : 'rounded-3xl'"
                 style="will-change: border-radius, width, height;">
                
                <!-- Collapsed Header Bar -->
                <div class="flex items-center justify-between px-8 py-3">
                    <!-- Left: Hamburger + Menu Text -->
                    <button @click="toggleMenu()" 
                            class="flex items-center gap-3 text-gray-900 hover:text-indigo-600 transition-all duration-300 group">
                        <!-- Hamburger Icon -->
                        <div class="flex flex-col gap-1.5 w-6 transition-transform duration-500" :class="menuOpen ? 'rotate-90' : ''">
                            <span class="block h-0.5 bg-current transition-all duration-500 ease-out" 
                                  :class="menuOpen ? 'rotate-45 translate-y-2' : ''"></span>
                            <span class="block h-0.5 bg-current transition-all duration-500 ease-out" 
                                  :class="menuOpen ? 'opacity-0' : ''"></span>
                            <span class="block h-0.5 bg-current transition-all duration-500 ease-out" 
                                  :class="menuOpen ? '-rotate-45 -translate-y-2' : ''"></span>
                        </div>
                        <span class="font-bold text-lg transition-opacity duration-300" x-show="!menuOpen">Menu</span>
                        <span class="font-bold text-lg transition-opacity duration-300" x-show="menuOpen" x-cloak>Close</span>
                    </button>

                    <!-- Center: Logo -->
                    <div class="absolute left-1/2 transform -translate-x-1/2 flex items-center">
                        @if(isset($globalSettings['logo_url']) && $globalSettings['logo_url'])
                            <img src="{{ $globalSettings['logo_url'] }}" alt="Logo" class="object-contain h-9 transition-all duration-300">
                        @elseif(isset($globalSettings['logo']) && $globalSettings['logo'])
                            <img src="{{ asset('storage/' . $globalSettings['logo']) }}" alt="Logo" class="object-contain h-9 transition-all duration-300">
                        @else
                            <span class="font-bold text-xl text-indigo-600">{{ config('app.name') }}</span>
                        @endif
                    </div>

                    <!-- Right: Contact & Login -->
                    <div class="flex items-center gap-5">
                        <a href="/contact" class="text-gray-900 hover:text-indigo-600 transition-all duration-300 font-medium px-3 py-1.5 rounded-lg hover:bg-gray-100">
                            Contact
                        </a>
                        <a href="/login" class="px-6 py-2.5 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-full transition-all duration-300 shadow-lg hover:shadow-green-500/50 hover:scale-105">
                            Login
                        </a>
                    </div>
                </div>

                <!-- Expanded Menu Content -->
                <div x-show="menuOpen" 
                     x-cloak
                     :class="menuState === 'expanded' ? 'menu-content-visible' : 'menu-content-hidden'"
                     class="px-12 pb-12 pt-6">
                    
                    <!-- Menu Grid -->
                    <div class="grid grid-cols-3 gap-14 mt-6">

                        <div class="space-y-3">
                            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-6 px-2">Main Menu</h3>
                            <div class="space-y-6">
                                @foreach($globalMenu->take(4) as $item)
                                <a href="{{ $item->url }}" 
                                   class="block text-gray-900 hover:text-indigo-600 menu-item-hover px-3 py-2 rounded-lg hover:bg-gray-50">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-1">
                                            <div class="font-semibold text-lg">
                                                {{ $item->label }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Column 2: More -->
                        <div class="space-y-3">
                            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-6 px-2">More</h3>
                            <div class="space-y-6">
                                @foreach($globalMenu->slice(4, 3) as $item)
                                <a href="{{ $item->url }}" 
                                   class="block text-gray-900 hover:text-indigo-600 menu-item-hover px-3 py-2 rounded-lg hover:bg-gray-50">
                                    <div class="font-semibold text-lg">
                                        {{ $item->label }}
                                    </div>
                                </a>
                                @endforeach
                                
                                <!-- Social Icons -->
                                <div class="flex gap-4 mt-10 px-2">
                                    <a href="#" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-indigo-600 hover:text-white text-gray-600 flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                    </a>
                                    <a href="#" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-indigo-600 hover:text-white text-gray-600 flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                    </a>
                                    <a href="#" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-indigo-600 hover:text-white text-gray-600 flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Column 3: FEATURED -->
                        <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-[1.02]">
                            <span class="inline-block px-4 py-1.5 bg-purple-800 text-purple-100 text-xs font-bold rounded-full mb-5">
                                MILESTONE
                            </span>
                            <h3 class="text-2xl font-bold text-white mb-4 leading-tight">
                                We hit 1600 Members!
                            </h3>
                            <button class="mt-6 px-7 py-3 bg-white text-gray-900 font-bold rounded-full hover:bg-gray-100 transition-all duration-300 hover:scale-105 shadow-lg">
                                Join them
                            </button>
                            
                            <!-- Member Avatars -->
                            <div class="flex -space-x-2 mt-7">
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 border-2 border-white transition-transform duration-300 hover:scale-110 hover:z-10"></div>
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-green-400 to-cyan-500 border-2 border-white transition-transform duration-300 hover:scale-110 hover:z-10"></div>
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-pink-400 to-red-500 border-2 border-white transition-transform duration-300 hover:scale-110 hover:z-10"></div>
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 border-2 border-white transition-transform duration-300 hover:scale-110 hover:z-10"></div>
                            </div>
                        </div>

                    </div>

                    <!-- Bottom Section: Earnings Badge -->
                    <div class="mt-10 pt-7 border-t border-gray-200 flex items-center justify-between">
                        <div class="flex items-center gap-3 text-gray-500 text-sm">
                            <span class="px-4 py-1.5 bg-gray-100 rounded-full font-semibold">Earnings</span>
                            <span class="text-gray-600">100%</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- MOBILE/TABLET TOP HEADER -->
    <!-- MOBILE/TABLET TOP HEADER -->
    <header class="lg:hidden fixed top-0 w-full h-16 bg-white/90 backdrop-blur-md border-b border-gray-200 z-50 flex items-center justify-between px-4 sm:px-6">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2">
           @if(isset($globalSettings['logo']) && $globalSettings['logo'])
                <img src="{{ asset('storage/' . $globalSettings['logo']) }}" alt="Logo" class="object-contain max-h-9" style="height: auto; width: auto; max-width: 200px;">
            @elseif(isset($globalSettings['logo_url']) && $globalSettings['logo_url'])
                <img src="{{ $globalSettings['logo_url'] }}" alt="Logo" class="object-contain max-h-9" style="height: auto; width: auto; max-width: 200px;">
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
        <div class="fixed inset-y-0 right-0 z-[100] w-full max-w-xs bg-white shadow-2xl transform transition-transform"
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
                    <button type="button" class="rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo- 500" @click="sidebarOpen = false">
                        <span class="sr-only">Close panel</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mt-6 relative flex-1 px-4 sm:px-6">
                    <nav class="flex flex-col space-y-4">
                        @if(isset($globalMenu))
                            @foreach($globalMenu as $item)
                                <a href="{{ $item->url }}"
                                   class="group flex items-center px-4 py-3 text-base font-medium rounded-xl transition-all duration-200
                                   {{ request()->fullUrlIs($item->url) || request()->is(ltrim($item->url, '/')) ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                                    {{ $item->label }}
                                    <span class="ml-auto opacity-0 group-hover:opacity-100 text-indigo-400 transition-opacity">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </span>
                                </a>
                            @endforeach
                        @endif
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

    <!-- MOBILE BOTTOM NAVBAR -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-white/90 backdrop-blur-xl border-t border-gray-200 z-40 flex items-center justify-around pb-safe shadow-[0_-4px_20px_-5px_rgba(0,0,0,0.1)]">
        @if(isset($globalMenu))
            @foreach($globalMenu->take(4) as $item)
                <a href="{{ $item->url }}" class="group flex flex-col items-center justify-center w-full h-full space-y-1 relative
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
        @endif
    </nav>

    <!-- VIDEO HERO SECTION -->
    <div class="relative w-full h-screen overflow-hidden">


        <!-- Background Video - Optimized for Lazy Loading -->
        <video class="absolute top-0 left-0 w-full h-full object-cover z-0" 
               autoplay 
               muted 
               loop 
               playsinline
               preload="metadata"
               poster="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1920 1080'%3E%3Crect fill='%23111' width='1920' height='1080'/%3E%3C/svg%3E">
            <source src="{{ asset('demovideo.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <!-- Use a darker overlay for better text contrast -->
        <div class="absolute inset-0 bg-black/50 z-10"></div>

        <!-- Hero Content -->
        <div class="relative z-20 h-full flex flex-col px-4 sm:px-6 lg:px-8 pointer-events-none">
            <!-- Spacer for fixed menu - reduced height to allow content to sit higher -->
            <div class="h-24 md:h-20 flex-shrink-0"></div>
            
            <!-- Content centered in remaining space -->
            <div class="flex-1 flex flex-col items-center justify-center pb-0 md:pb-12">
                
                <h1 class="text-6xl md:text-7xl lg:text-8xl font-black text-center mb-6 tracking-tight drop-shadow-2xl">
                    <span class="text-white font-bold">Aaha</span> 
                    <span class="text-white font-bold">Apps</span>
                </h1>
                
                <p class="text-lg md:text-2xl text-center text-gray-200 mb-10 max-w-2xl font-medium leading-relaxed drop-shadow-md">
                    Igniting <span class="font-bold text-white border-b-2 border-indigo-500">digital excellence</span> with premium Video & Web solutions.
                </p>
            </div>
        </div>
        <!-- Horizontal Draggable Carousel at Bottom -->
        <div class="horizontal-carousel-wrapper" id="horizontalCarouselWrapper">
            <div class="horizontal-carousel-track" id="horizontalCarouselTrack">
                @php
                    $loopItems = collect();
                    $sourceItems = (isset($circularItems) && $circularItems->count() > 0) ? $circularItems : collect();
                    
                    if ($sourceItems->count() > 0) {
                        // Duplicate items for infinite loop
                        $loopItems = $sourceItems->concat($sourceItems)->concat($sourceItems);
                    }
                @endphp
                @foreach($loopItems as $index => $item)
                    <div class="carousel-card" @if($item->color) style="background: {{ $item->color }} !important;" @endif>
                        <a href="{{ $item->link ?? '#' }}" @if(Str::startsWith($item->link ?? '', 'http')) target="_blank" @endif class="group flex flex-col justify-around items-center w-full h-full text-decoration-none card-link" data-href="{{ $item->link ?? '#' }}">
                            <h3 class="text-base md:text-lg font-bold mb-1 transition-colors" @if($item->text_color) style="color: {{ $item->text_color}} !important;" @endif>{{ $item->title }}</h3>
                            
                            @if($item->description)
                            <p class="text-xs mb-2 line-clamp-2" @if($item->text_color) style="color: {{ $item->text_color }} !important;" @endif>{{ Str::limit($item->description, 60) }}</p>
                            @endif

                            <span class="explore-btn relative z-10 inline-block cursor-pointer text-[10px] md:text-xs uppercase tracking-widest border px-3 py-1.5 rounded-full bg-transparent transition-colors duration-300" @if($item->text_color) style="color: {{ $item->text_color }} !important; border-color: {{ $item->text_color }} !important;" @endif>
                                {{ $item->button_text }}
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>



    @livewireScripts




    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Force scroll to top on refresh
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }
            window.scrollTo(0, 0);

            // Horizontal Carousel Logic
            const track = document.getElementById('horizontalCarouselTrack');
            const wrapper = document.getElementById('horizontalCarouselWrapper');
            
            if (!track || !wrapper) return;
            
            const cards = track.querySelectorAll('.carousel-card');
            if (cards.length === 0) return;
            
            // Calculate total width
            const cardWidth = cards[0].offsetWidth;
            const gap = 20;
            const singleSetWidth = (cardWidth + gap) * (cards.length / 3); // Divide by 3 because we tripled items
            
            
            // Animation variables
            let currentX = 0;
            let targetX = 0;
            let isDragging = false;
            let isDragged = false; // Track if actually dragged
            let isPaused = false;
            let startX = 0;
            let velocity = 0;
            const friction = 0.95;
            const autoScrollSpeed = {{ \App\Models\Setting::get('card_animation_speed', 1) }}; // From CMS settings
            
            function animate() {
                if (!isDragging && !isPaused) {
                    // Auto-scroll from left to right
                    targetX -= autoScrollSpeed;
                    
                    // Add velocity if exists
                    if (Math.abs(velocity) > 0.01) {
                        targetX += velocity;
                        velocity *= friction;
                    }
                    
                    // Infinite loop: reset when scrolled one set
                    if (Math.abs(targetX) >= singleSetWidth) {
                        targetX = targetX % singleSetWidth;
                        currentX = targetX;
                    }
                }
                
                // Smooth interpolation
                currentX += (targetX - currentX) * 0.1;
                track.style.transform = `translateX(${currentX}px)`;
                
                requestAnimationFrame(animate);
            }
            animate();
            
            // Drag functionality
            let lastX = 0;
            const dragThreshold = 5; // Minimum pixels to consider it a drag
            
            wrapper.addEventListener('mousedown', (e) => {
                isDragging = true;
                isDragged = false;
                startX = e.clientX;
                lastX = e.clientX;
                velocity = 0;
                track.style.cursor = 'grabbing';
            });
            
            window.addEventListener('mouseup', () => {
                if (isDragging) {
                    isDragging = false;
                    track.style.cursor = 'grab';
                }
            });
            
            window.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                
                const deltaX = e.clientX - lastX;
                const totalDrag = Math.abs(e.clientX - startX);
                
                // If dragged more than 5 pixels, mark as dragged
                if (totalDrag > 5) {
                    isDragged = true;
                }
                
                lastX = e.clientX;
                targetX += deltaX;
                velocity = deltaX * 0.5;
            });
            
            // Touch support
            wrapper.addEventListener('touchstart', (e) => {
                isDragging = true;
                isDragged = false;
                startX = e.touches[0].clientX;
                lastX = e.touches[0].clientX;
                velocity = 0;
            });
            
            window.addEventListener('touchend', () => {
                if (isDragging) {
                    isDragging = false;
                }
            });
            
            window.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                
                const touch = e.touches[0];
                const deltaX = touch.clientX - lastX;
                const totalDrag = Math.abs(touch.clientX - startX);
                
                if (totalDrag > 5) {
                    isDragged = true;
                }
                
                lastX = touch.clientX;
                targetX += deltaX;
                velocity = deltaX * 0.5;
            });
            
            // Prevent link clicks when dragging
            document.querySelectorAll('.card-link').forEach(link => {
                link.addEventListener('click', (e) => {
                    if (isDragged) {
                        e.preventDefault();
                        isDragged = false; // Reset
                    }
                });
            });
            
            // Pause animation on card hover
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    isPaused = true;
                });
                
                card.addEventListener('mouseleave', () => {
                    isPaused = false;
                });
            });
        });


    </script>
</body>
</html>