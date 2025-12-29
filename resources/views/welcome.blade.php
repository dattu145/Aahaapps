<x-layouts.public>
    
    <!-- Custom Styles -->
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
    </style>

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
            <div class="grid gap-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                
                @foreach($services as $index => $service)
                <div class="group relative h-[350px] rounded-3xl overflow-hidden cursor-pointer"
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
                    <div class="absolute bottom-0 left-0 right-0 p-8 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <span class="inline-block px-4 py-1.5 glass-panel rounded-full text-xs font-semibold text-white mb-4">
                            Service
                        </span>
                        <h3 class="text-3xl font-bold text-white mb-3 leading-tight group-hover:text-indigo-300 transition-colors">
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
</x-layouts.public>
