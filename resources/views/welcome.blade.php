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
            max-height: 70px;
            transition: width 1s cubic-bezier(0.5, 1.2, 0.64, 1),
                        max-height 1s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Stage 1: Expanding Horizontally (1s duration, height stays same) */
        .menu-expanding-horizontal {
            width: calc(100vw - 6rem);
            max-width: 1400px;
            max-height: 70px; /* SAME as collapsed - no vertical expansion yet! */
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
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-900 font-sans selection:bg-indigo-100 selection:text-indigo-700" 
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
        <div class="fixed top-8 left-1/2 transform -translate-x-1/2 z-50"
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
                <div class="flex items-center justify-between px-8 py-5">
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
                        
                        <!-- Column 1: OUR PRODUCTS -->
                        <div class="space-y-3">
                            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-6 px-2">Our Products</h3>
                            <div class="space-y-6">
                                @foreach($services->take(4) as $service)
                                <a href="{{ $service->login_url ?: '#' }}" 
                                   class="block text-gray-900 hover:text-indigo-600 menu-item-hover px-3 py-2 rounded-lg hover:bg-gray-50">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-1">
                                            <div class="font-semibold text-lg">
                                                {{ $service->name }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Column 2: EXPLORE -->
                        <div class="space-y-3">
                            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-6 px-2">Explore</h3>
                            <div class="space-y-6">
                                @foreach($services->slice(4, 3) as $service)
                                <a href="{{ $service->login_url ?: '#' }}" 
                                   class="block text-gray-900 hover:text-indigo-600 menu-item-hover px-3 py-2 rounded-lg hover:bg-gray-50">
                                    <div class="font-semibold text-lg">
                                        {{ $service->name }}
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
    <header class="lg:hidden fixed top-0 w-full h-16 bg-white/90 backdrop-blur-md border-b border-gray-200 z-40 flex items-center justify-between px-4 sm:px-6">
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
                    <button type="button" class="rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo- 500" @click="sidebarOpen = false">
                        <span class="sr-only">Close panel</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mt-6 relative flex-1 px-4 sm:px-6">
                    <nav class="flex flex-col space-y-4">
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
    </nav>

    <!-- VIDEO HERO SECTION -->
    <div class="relative w-full h-screen overflow-hidden">
        <!-- Background Video -->
        <video class="absolute top-0 left-0 w-full h-full object-cover z-0" autoplay muted loop playsinline>
            <source src="{{ asset('demovideo.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <!-- Use a darker overlay for better text contrast -->
        <div class="absolute inset-0 bg-black/50 z-10"></div>

        <!-- Hero Content -->
        <div class="relative z-20 h-full flex flex-col items-center justify-center text-center px-4 sm:px-6 lg:px-8">
            
            <h1 class="text-6xl md:text-8xl lg:text-9xl font-extrabold text-white tracking-tighter mb-6 opacity-0 animate-fade-in-up">
                Aaha Apps
            </h1>

            <p class="text-xl md:text-3xl text-gray-200 max-w-4xl mx-auto font-light leading-relaxed mb-10 opacity-0 animate-fade-in-up delay-300">
                Igniting <span class="font-semibold text-white">digital excellence</span> with premium Video & Web solutions.
            </p>

            <div class="flex gap-6 opacity-0 animate-fade-in-up delay-500">
                <a href="#services" class="px-10 py-5 bg-white text-black font-bold text-lg rounded-full hover:scale-105 transition-transform duration-300 shadow-[0_0_20px_rgba(255,255,255,0.3)]">
                    Explore Services
                </a>
                <a href="/contact" class="px-10 py-5 glass-panel text-white font-bold text-lg rounded-full hover:bg-white/20 transition-all duration-300">
                    Contact Us
                </a>
            </div>
        </div>
    </div>

    <!-- FULL WIDTH DYNAMIC SERVICES GRID -->
    <div id="services" class="relative w-full bg-gray-950 py-24">
        <div class="w-full px-4 md:px-8">
            
            <!-- Section Header -->
            <div class="text-center mb-20"
                 x-data="{ show: false }"
                 x-intersect.once="show = true">
                <h2 class="text-sm text-indigo-400 font-bold tracking-[0.3em] uppercase mb-4 opacity-0 transition-all duration-700 transform"
                    :class="show ? 'opacity-100 translate-y-0' : 'translate-y-4'">
                    What We Do
                </h2>
                <p class="text-5xl md:text-7xl font-bold text-white opacity-0 transition-all duration-700 delay-100 transform"
                   :class="show ? 'opacity-100 translate-y-0' : 'translate-y-4'">
                    Our Services
                </p>
            </div>

            <!-- Dynamic Grid -->
            <div class="grid gap-8 grid-cols-1 min-[451px]:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                
                @foreach($services as $index => $service)
                <div class="group relative h-[280px] sm:h-[350px] rounded-3xl overflow-hidden cursor-pointer"
                     x-data="{ show: false }"
                     x-intersect.half="show = true"
                     :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                     style="transition: all 0.6s ease-out; transition-delay: {{ $index * 100 }}ms;">
                    
                    <!-- Image Background -->
                    @if($service->image)
                        <img src="{{ Str::startsWith($service->image, 'http') ? $service->image : Storage::url($service->image) }}" 
                             alt="{{ $service->name }}" 
                             class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out">
                    @else
                        <!-- Fallback Image if none provided -->
                        <img src="https://source.unsplash.com/random/800x1000/?{{ Str::slug($service->name) }}" 
                             alt="{{ $service->name }}" 
                             class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out">
                    @endif
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-300"></div>
                    
                    <!-- Content -->
                    <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-8 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <span class="inline-block px-4 py-1.5 glass-panel rounded-full text-xs font-semibold text-white mb-4">
                            Service
                        </span>
                        <h3 class="text-2xl sm:text-3xl font-bold text-white mb-3 leading-tight group-hover:text-indigo-300 transition-colors">
                            {{ $service->name }}
                        </h3>
                        <p class="text-gray-300 text-sm line-clamp-3 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
                            {{ $service->description }}
                        </p>
                        
                        <div class="mt-6 flex justify-between items-center opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-200">
                            <a href="{{ $service->login_url ?: 'https://profile.aahaapps.com' }}" class="text-white font-semibold hover:text-indigo-400 transition-colors">Login</a>
                            
                            @php
                                $whatsapp = \App\Models\Setting::get('whatsapp_number');
                                $enquiryUrl = $whatsapp ? "https://wa.me/{$whatsapp}?text=I am interested in " . urlencode($service->name) : "/contact";
                            @endphp

                            <a href="{{ $enquiryUrl }}" class="px-5 py-2 bg-white text-black text-sm font-bold rounded-full hover:bg-gray-200 transition-colors" {{ $whatsapp ? 'target="_blank"' : '' }}>
                                Enquiry
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
