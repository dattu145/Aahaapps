<x-layouts.public :page="$page">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-6 md:p-10 animate-fade-in-up">
            @if($page->image)
                <div class="mb-8 rounded-2xl overflow-hidden shadow-md h-64 md:h-96 relative group">
                    <img src="{{ asset('storage/' . $page->image) }}" alt="{{ $page->title }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-60"></div>
                </div>
            @endif

            <h1 class="text-3xl md:text-5xl font-extrabold mb-6 text-gray-900 tracking-tight leading-tight">{{ $page->title }}</h1>
            
            <div class="cms-content max-w-none mb-12 text-gray-600 leading-relaxed">
                <style>
                    /* Replicate Editor Styles for 1:1 Match */
                    .cms-content h1 { font-size: 2.25rem !important; font-weight: 800 !important; margin-bottom: 1rem !important; line-height: 1.2 !important; color: #111827; }
                    .cms-content h2 { font-size: 1.875rem !important; font-weight: 700 !important; margin-bottom: 0.75rem !important; line-height: 1.3 !important; color: #1f2937; }
                    .cms-content h3 { font-size: 1.5rem !important; font-weight: 600 !important; margin-bottom: 0.5rem !important; line-height: 1.4 !important; color: #374151; }
                    .cms-content h4 { font-size: 1.25rem !important; font-weight: 600 !important; margin-bottom: 0.5rem !important; color: #374151; }
                    .cms-content h5 { font-size: 1.125rem !important; font-weight: 600 !important; margin-bottom: 0.5rem !important; color: #374151; }
                    .cms-content h6 { font-size: 1rem !important; font-weight: 600 !important; margin-bottom: 0.5rem !important; color: #374151; }
                    .cms-content p { margin-bottom: 1rem !important; }

                    /* Lists */
                    .cms-content ul { list-style: disc !important; padding-left: 2rem !important; margin-bottom: 1rem !important; }
                    .cms-content ul ul { list-style: circle !important; }
                    .cms-content ul ul ul { list-style: square !important; }
                    .cms-content ol { list-style: decimal !important; padding-left: 2rem !important; margin-bottom: 1rem !important; }
                    .cms-content ol ol { list-style: lower-alpha !important; }
                    .cms-content ol ol ol { list-style: lower-roman !important; }
                    .cms-content li { display: list-item !important; margin-bottom: 0.25rem !important; }

                    /* Force responsive images/videos/iframes */
                    .cms-content img, .cms-content video, .cms-content iframe {
                        max-width: 100% !important;
                        height: auto !important;
                    }
                    /* Responsive Tables */
                    .cms-content table {
                        display: block;
                        width: 100%;
                        overflow-x: auto;
                        border-collapse: collapse;
                    }
                    .cms-content td, .cms-content th {
                        border: 1px solid #e5e7eb;
                        padding: 0.5rem;
                    }
                </style>
                {!! $page->content !!}
            </div>

            @if($page->cta_text && $page->cta_url)
                <div class="mt-8 mb-16 text-center" x-data="{ loading: false }">
                    <a href="{{ $page->cta_url }}" 
                       @click="loading = true"
                       class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-full text-white bg-indigo-600 hover:bg-indigo-700 hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 relative overflow-hidden">
                        <span x-show="!loading">{{ $page->cta_text }}</span>
                        <span x-show="loading" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Redirecting...
                        </span>
                    </a>
                </div>
            @endif
            
            @if($page->slug === 'home' && isset($services) && $services->count() > 0)
                <div class="mt-16 border-t border-gray-100 pt-16">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Our Services</h2>
                        <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">Comprehensive solutions tailored for your growth.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($services as $service)
                            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden flex flex-col h-full group">
                                @if($service->image)
                                    <div class="h-56 w-full overflow-hidden bg-gray-50 relative">
                                        <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors duration-300 z-10"></div>
                                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                    </div>
                                @elseif($service->image_url)
                                    <div class="h-56 w-full overflow-hidden bg-gray-50 relative">
                                         <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors duration-300 z-10"></div>
                                        <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                    </div>
                                @else
                                    <div class="h-56 w-full bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center group-hover:from-indigo-100 group-hover:to-purple-100 transition-colors duration-300">
                                        <span class="text-5xl text-indigo-200 font-extrabold group-hover:text-indigo-300 transition-colors duration-300">{{ substr($service->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                
                                <div class="p-8 flex flex-col flex-grow relative">
                                    <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors duration-300">{{ $service->name }}</h3>
                                    <p class="text-gray-600 mb-8 flex-grow text-base leading-relaxed">{{ Str::limit($service->description, 120) }}</p>
                                    
                                    <div class="flex space-x-4 mt-auto">
                                        <!-- Login Button -->
                                        <a href="{{ $service->login_url ?? \App\Models\Setting::get('min_login_url') ?? 'https://profile.aahaapps.com/' }}" 
                                           target="_blank"
                                           class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 text-white font-bold py-3 px-4 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg">
                                            Login
                                        </a>

                                        <!-- Enquiry Button -->
                                        @php
                                            $phone = \App\Models\Setting::get('whatsapp_number');
                                            $text = urlencode("Hi, I'm interested in " . $service->name);
                                            $waLink = $phone ? "https://wa.me/{$phone}?text={$text}" : "#";
                                        @endphp
                                        <a href="{{ $waLink }}" 
                                           target="_blank"
                                           class="flex-1 text-center bg-emerald-500 hover:bg-emerald-600 focus:ring-4 focus:ring-emerald-200 text-white font-bold py-3 px-4 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg">
                                            Enquiry
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.public>
