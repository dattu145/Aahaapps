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

        /* Enhanced Menu Animation Styles */
        .menu-collapsed {
            width: 680px;
            max-height: 50px;
            transition: width 1s cubic-bezier(0.5, 1.2, 0.64, 1),
                        max-height 1s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .menu-expanding-horizontal {
            width: calc(100vw - 6rem);
            max-width: 1400px;
            max-height: 50px;
            transition: width 1s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .menu-expanded {
            width: calc(100vw - 6rem);
            max-width: 1400px;
            max-height: 900px;
            transition: max-height 1s cubic-bezier(0.14, 0.10, 1.65, 5) 2s;
        }

        .menu-content-hidden {
            opacity: 0;
            transform: translateY(-20px);
            pointer-events: none;
            transition: opacity 0.3s ease-out, transform 0.3s ease-out;
        }

        .menu-content-visible {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
            transition: opacity 0.4s ease-out 0.3s, transform 0.4s ease-out 0.3s;
        }

        .menu-item-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .menu-item-hover:hover {
            transform: translateX(4px);
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
                overflow-x: hidden;
            }
        }

        /* Scroll Lock Utility */
        .no-scroll {
            overflow: hidden;
            height: 100vh;
        }

        /* NEW: Enhanced Card Layout Styles */
        .card-layout-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .card-item-wrapper {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-item-wrapper:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        /* Desktop Card Layout (min-width: 1024px) */
        .desktop-card {
            display: grid;
            grid-template-columns: 170px 520px 1fr; /* Screenshot | Main Image | Content */
            grid-template-rows: 1fr auto; /* Content | Footer Buttons */
            gap: 12px;
            padding: 16px;
            min-height: 450px;
        }

        /* Left Screenshot Column (Desktop) */
        .desktop-screenshots {
            grid-column: 1;
            grid-row: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
            overflow-y: auto;
            max-height: 500px;
            padding-right: 4px;
        }

        .desktop-screenshot-item {
            width: 150px;
            height: 110px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            cursor: pointer;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .desktop-screenshot-item:hover {
            transform: scale(1.05);
            border-color: #4f46e5;
        }

        .desktop-screenshot-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Center Main Image Column (Desktop) */
        .desktop-main-image {
            grid-column: 2;
            grid-row: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 5px;
            width: 100%;
        }

        .main-image-container {
            width: 100%;
            height: 450px; /* Increased Height */
            border-radius: 12px;
            overflow: hidden;
            background: #f9fafb;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-image-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.5s ease;
        }

        .main-image-container:hover img {
            transform: scale(1.02);
        }

        /* Right Content Column (Desktop) */
        .desktop-content {
            grid-column: 3;
            grid-row: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 12px;
            padding-left: 5px;
        }

        .content-header {
            text-align: left;
        }

        .card-title {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .card-description {
            font-size: 15px;
            line-height: 1.6;
            color: #4b5563;
        }

        /* Footer Actions (Desktop) */
        .content-actions {
            grid-column: 1 / -1;
            grid-row: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
            margin-top: 4px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            min-width: 100px;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .enquiry-btn {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 0;
            min-width: 140px;
        }

        .enquiry-btn:hover {
            background: linear-gradient(135deg, #4338ca, #6d28d9);
        }

        /* Mobile Card Layout (max-width: 1023px) */
        .mobile-card {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }

        /* Mobile Screenshot Row */
        .mobile-screenshots {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding-bottom: 12px;
            margin-bottom: 8px;
            scrollbar-width: none;
        }

        .mobile-screenshots::-webkit-scrollbar {
            display: none;
        }

        .mobile-screenshot-item {
            flex-shrink: 0;
            width: 120px;
            height: 90px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .mobile-screenshot-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Mobile Main Image */
        .mobile-main-image {
            width: 100%;
            height: 250px;
            border-radius: 12px;
            overflow: hidden;
            background: #f9fafb;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-main-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        /* Mobile Content */
        .mobile-content {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .mobile-title {
            font-size: 22px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
        }

        .mobile-description {
            font-size: 14px;
            line-height: 1.6;
            color: #6b7280;
            text-align: center;
        }

        .mobile-actions {
            display: flex;
            flex-direction: column;
            gap: 16px;
            align-items: center;
        }

        .mobile-action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .mobile-action-btn {
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            min-width: 110px;
        }

        .mobile-enquiry-btn {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            max-width: 200px;
        }

        /* Custom scrollbar styling */
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1023px) {
            .desktop-card {
                display: none;
            }
            
            .mobile-card {
                display: flex;
            }
            
            .card-layout-container {
                padding: 16px;
                gap: 20px;
            }
        }

        @media (min-width: 1024px) {
            .desktop-card {
                display: grid;
            }
            
            .mobile-card {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .mobile-main-image {
                height: 200px;
            }
            
            .mobile-action-buttons {
                flex-direction: column;
                align-items: center;
                width: 100%;
            }
            
            .mobile-action-btn {
                width: 100%;
                max-width: 200px;
            }
            
            .mobile-enquiry-btn {
                max-width: 100%;
            }
        }

        /* Video Hero Section */
        .video-hero-section {
            position: relative;
            min-height: 100vh;
            width: 100%;
            overflow-y: auto;
        }

        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .video-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }

        .content-wrapper {
            position: relative;
            z-index: 10;
            padding-top: 120px; /* Reduced Gap */
            padding-bottom: 80px;
        }

        /* Menu spacing */
        .menu-spacer {
            height: 80px; /* Reduced Gap */
        }

        @media (max-width: 768px) {
            .menu-spacer {
                height: 60px;
            }
            
            .content-wrapper {
                padding-top: 100px;
            }
        }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-900 font-sans selection:bg-indigo-100 selection:text-indigo-700 overflow-x-hidden" 
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

    <!-- DESKTOP ANIMATED MENU -->
    <div class="hidden lg:block">
        <div class="absolute top-8 left-1/2 transform -translate-x-1/2 z-[9999]"
             style="z-index: 9999;"
             @click.outside="if (menuOpen) toggleMenu()"
             :class="{
                 'menu-collapsed': menuState === 'collapsed',
                 'menu-expanding-horizontal': menuState === 'expanding-horizontal',
                 'menu-expanded': menuState === 'expanded'
             }">
            
            <div class="bg-white shadow-2xl border border-gray-200 transition-all duration-700 ease-out"
                 :class="menuOpen ? 'rounded-2xl' : 'rounded-3xl'"
                 style="will-change: border-radius, width, height;">
                
                <div class="flex items-center justify-between px-8 py-3">
                    <button @click="toggleMenu()" 
                            class="flex items-center gap-3 text-gray-900 hover:text-indigo-600 transition-all duration-300 group">
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

                    <div class="absolute left-1/2 transform -translate-x-1/2 flex items-center">
                        @if(isset($globalSettings['logo_url']) && $globalSettings['logo_url'])
                            <img src="{{ $globalSettings['logo_url'] }}" alt="Logo" class="object-contain h-9 transition-all duration-300">
                        @elseif(isset($globalSettings['logo']) && $globalSettings['logo'])
                            <img src="{{ asset('storage/' . $globalSettings['logo']) }}" alt="Logo" class="object-contain h-9 transition-all duration-300">
                        @else
                            <span class="font-bold text-xl text-indigo-600">{{ config('app.name') }}</span>
                        @endif
                    </div>

                    <div class="flex items-center gap-5">
                        <a href="/contact" class="text-gray-900 hover:text-indigo-600 transition-all duration-300 font-medium px-3 py-1.5 rounded-lg hover:bg-gray-100">
                            Contact
                        </a>
                        <a href="/login" class="px-6 py-2.5 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-full transition-all duration-300 shadow-lg hover:shadow-green-500/50 hover:scale-105">
                            Login
                        </a>
                    </div>
                </div>

                <div x-show="menuOpen" 
                     x-cloak
                     :class="menuState === 'expanded' ? 'menu-content-visible' : 'menu-content-hidden'"
                     class="px-12 pb-12 pt-6">
                    
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
                            
                            <div class="flex -space-x-2 mt-7">
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 border-2 border-white transition-transform duration-300 hover:scale-110 hover:z-10"></div>
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-green-400 to-cyan-500 border-2 border-white transition-transform duration-300 hover:scale-110 hover:z-10"></div>
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-pink-400 to-red-500 border-2 border-white transition-transform duration-300 hover:scale-110 hover:z-10"></div>
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 border-2 border-white transition-transform duration-300 hover:scale-110 hover:z-10"></div>
                            </div>
                        </div>
                    </div>

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
    <header class="lg:hidden fixed top-0 w-full h-16 bg-white/90 backdrop-blur-md border-b border-gray-200 z-50 flex items-center justify-between px-4 sm:px-6">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
           @if(isset($globalSettings['logo']) && $globalSettings['logo'])
                <img src="{{ asset('storage/' . $globalSettings['logo']) }}" alt="Logo" class="object-contain max-h-9" style="height: auto; width: auto; max-width: 200px;">
            @elseif(isset($globalSettings['logo_url']) && $globalSettings['logo_url'])
                <img src="{{ $globalSettings['logo_url'] }}" alt="Logo" class="object-contain max-h-9" style="height: auto; width: auto; max-width: 200px;">
            @else
                <span class="font-bold text-xl text-indigo-600">{{ config('app.name') }}</span>
            @endif
        </a>

        <button @click="sidebarOpen = true" class="p-2 -mr-2 text-gray-600 hover:text-indigo-600 focus:outline-none transition-colors duration-200">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </header>

    <!-- RIGHT SLIDE-OVER DRAWER -->
    <div class="relative z-50 lg:hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true" 
         x-show="sidebarOpen" 
         style="display: none;">
         
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
             x-show="sidebarOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"></div>

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
                    <button type="button" class="rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500" @click="sidebarOpen = false">
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
                    
                    @if(request()->fullUrlIs($item->url) || request()->is(ltrim($item->url, '/')))
                        <span class="absolute top-0 left-1/2 transform -translate-x-1/2 w-8 h-0.5 bg-indigo-600 rounded-full"></span>
                    @endif

                    <div class="w-6 h-6 rounded-full flex items-center justify-center transition-all duration-300 group-hover:-translate-y-1">
                        <span class="text-sm font-bold uppercase">{{ substr($item->label, 0, 1) }}</span>
                    </div>
                    <span class="text-[10px] font-medium tracking-wide">{{ $item->label }}</span>
                </a>
            @endforeach
        @endif
    </nav>

    <!-- VIDEO HERO SECTION -->
    <div class="video-hero-section">
        <!-- Background Video -->
        <video class="video-background" 
               autoplay 
               muted 
               loop 
               playsinline
               preload="metadata"
               poster="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1920 1080'%3E%3Crect fill='%23111' width='1920' height='1080'/%3E%3C/svg%3E">
            <source src="{{ asset('demovideo.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <!-- Dark Overlay -->
        <div class="video-overlay"></div>

        <!-- Menu Spacer -->
        <div class="menu-spacer"></div>

        <!-- Cards Content -->
        <div class="content-wrapper">
            <div class="card-layout-container">
                @if(isset($circularItems) && $circularItems->count() > 0)
                    @foreach($circularItems as $card)
                    <!-- Card Item: {{ $card->title }} -->
                    <div class="card-item-wrapper animate-fade-in-up" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                        
                        <!-- DESKTOP VERSION (1024px and above) -->
                        <div class="desktop-card">
                            <!-- Left: Screenshots (Vertical Scroll) -->
                            @if($card->section1_images && count($card->section1_images) > 0)
                            <div class="desktop-screenshots scrollbar-thin">
                                @foreach($card->section1_images as $index => $thumbnail)
                                <div class="desktop-screenshot-item">
                                    <img src="{{ Storage::url($thumbnail) }}" 
                                         alt="Screenshot {{ $index + 1 }}"
                                         data-index="{{ $index }}">
                                </div>
                                @endforeach
                            </div>
                            @endif

                            <!-- Center: Main Image -->
                            <div class="desktop-main-image">
                                @if($card->section2_image)
                                <div class="main-image-container">
                                    <img src="{{ Str::startsWith($card->section2_image, 'http') ? $card->section2_image : Storage::url($card->section2_image) }}" 
                                         alt="{{ $card->title }}"
                                         id="main-image-{{ $card->id }}">
                                </div>
                                @endif
                            </div>

                            <!-- Right: Content -->
                            <div class="desktop-content">
                                <div class="content-header">
                                    <h2 class="card-title" style="color: {{ $card->title_color ?? '#111827' }}">
                                        {{ $card->title }}
                                    </h2>
                                    
                                    @if($card->description)
                                    <p class="card-description" style="color: {{ $card->desc_color ?? '#6b7280' }}">
                                        {{ $card->description }}
                                    </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Footer: Buttons (Spans full width) -->
                            <div class="content-actions">
                                @if($card->buttons && count($card->buttons) > 0)
                                <div class="action-buttons">
                                    @foreach($card->buttons as $button)
                                    <a href="{{ $button['link'] ?? '#' }}" 
                                       class="action-btn"
                                       style="background-color: {{ $button['bg_color'] ?? '#111827' }}; color: {{ $button['text_color'] ?? '#ffffff' }}">
                                        {{ $button['text'] ?? 'Button' }}
                                    </a>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if($card->enquiry_link)
                                <a href="{{ $card->enquiry_link }}" 
                                   class="enquiry-btn">
                                    Enquiry
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </div>

                        <!-- MOBILE VERSION (1023px and below) -->
                        <div class="mobile-card">
                            <!-- Top: Screenshots (Horizontal Scroll) -->
                            @if($card->section1_images && count($card->section1_images) > 0)
                            <div class="mobile-screenshots scrollbar-hide">
                                @foreach($card->section1_images as $index => $thumbnail)
                                <div class="mobile-screenshot-item">
                                    <img src="{{ Storage::url($thumbnail) }}" 
                                         alt="Screenshot {{ $index + 1 }}">
                                </div>
                                @endforeach
                            </div>
                            @endif

                            <!-- Center: Main Image -->
                            @if($card->section2_image)
                            <div class="mobile-main-image">
                                <img src="{{ Str::startsWith($card->section2_image, 'http') ? $card->section2_image : Storage::url($card->section2_image) }}" 
                                     alt="{{ $card->title }}">
                            </div>
                            @endif

                            <!-- Bottom: Content -->
                            <div class="mobile-content">
                                <h2 class="mobile-title" style="color: {{ $card->title_color ?? '#111827' }}">
                                    {{ $card->title }}
                                </h2>
                                
                                @if($card->description)
                                <p class="mobile-description" style="color: {{ $card->desc_color ?? '#6b7280' }}">
                                    {{ $card->description }}
                                </p>
                                @endif

                                <div class="mobile-actions">
                                    @if($card->buttons && count($card->buttons) > 0)
                                    <div class="mobile-action-buttons">
                                        @foreach($card->buttons as $button)
                                        <a href="{{ $button['link'] ?? '#' }}" 
                                           class="mobile-action-btn"
                                           style="background-color: {{ $button['bg_color'] ?? '#111827' }}; color: {{ $button['text_color'] ?? '#ffffff' }}">
                                            {{ $button['text'] ?? 'Button' }}
                                        </a>
                                        @endforeach
                                    </div>
                                    @endif
                                    
                                    @if($card->enquiry_link)
                                    <a href="{{ $card->enquiry_link }}" 
                                       class="mobile-enquiry-btn">
                                        Enquiry
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- No cards message -->
                    <div class="text-white text-center py-12 w-full">
                        <p class="text-xl">No cards available. Please add cards from the admin panel.</p>
                    </div>
                @endif
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

            // Initialize screenshot click functionality for desktop
            document.querySelectorAll('.desktop-screenshot-item').forEach(item => {
                item.addEventListener('click', function() {
                    const index = this.getAttribute('data-index');
                    const cardId = this.closest('.card-item-wrapper').querySelector('.main-image-container img').id.replace('main-image-', '');
                    const mainImage = document.getElementById(`main-image-${cardId}`);
                    
                    if (mainImage && this.querySelector('img')) {
                        // In a real implementation, you might want to switch to a different image
                        // For now, just add a visual feedback
                        this.style.borderColor = '#4f46e5';
                        this.style.boxShadow = '0 0 0 3px rgba(79, 70, 229, 0.3)';
                        
                        // Reset other thumbnails
                        const siblings = this.parentElement.querySelectorAll('.desktop-screenshot-item');
                        siblings.forEach(sib => {
                            if (sib !== this) {
                                sib.style.borderColor = '#e5e7eb';
                                sib.style.boxShadow = 'none';
                            }
                        });
                    }
                });
            });

            // Mobile screenshot horizontal scroll with mouse drag
            const mobileScreenshots = document.querySelectorAll('.mobile-screenshots');
            
            mobileScreenshots.forEach(slider => {
                let isDown = false;
                let startX;
                let scrollLeft;

                slider.addEventListener('mousedown', (e) => {
                    isDown = true;
                    slider.classList.add('active');
                    startX = e.pageX - slider.offsetLeft;
                    scrollLeft = slider.scrollLeft;
                });

                slider.addEventListener('mouseleave', () => {
                    isDown = false;
                    slider.classList.remove('active');
                });

                slider.addEventListener('mouseup', () => {
                    isDown = false;
                    slider.classList.remove('active');
                });

                slider.addEventListener('mousemove', (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - slider.offsetLeft;
                    const walk = (x - startX) * 2;
                    slider.scrollLeft = scrollLeft - walk;
                });

                // Touch support for mobile
                slider.addEventListener('touchstart', (e) => {
                    isDown = true;
                    startX = e.touches[0].pageX - slider.offsetLeft;
                    scrollLeft = slider.scrollLeft;
                });

                slider.addEventListener('touchend', () => {
                    isDown = false;
                });

                slider.addEventListener('touchmove', (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.touches[0].pageX - slider.offsetLeft;
                    const walk = (x - startX) * 2;
                    slider.scrollLeft = scrollLeft - walk;
                });
            });
        });
    </script>
</body>
</html>