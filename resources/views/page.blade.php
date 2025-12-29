<x-layouts.public :page="$page">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            @if($page->image)
                <div class="mb-8 rounded-xl overflow-hidden shadow-lg h-64 md:h-96">
                    <img src="{{ asset('storage/' . $page->image) }}" alt="{{ $page->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <h1 class="text-3xl font-bold mb-4">{{ $page->title }}</h1>
            <div class="prose max-w-none mb-10">
                {!! nl2br(e($page->content)) !!}
            </div>

            @if($page->cta_text && $page->cta_url)
                <div class="mt-8 mb-12 text-center">
                    <a href="{{ $page->cta_url }}" 
                       class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10 transition-colors duration-200">
                        {{ $page->cta_text }}
                    </a>
                </div>
            @endif
            
            @if($page->slug === 'home' && isset($services) && $services->count() > 0)
                <div class="mt-8">
                    <h2 class="text-2xl font-bold mb-6 text-gray-800">Our Services</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($services as $service)
                            <div class="bg-white border rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden flex flex-col h-full">
                                @if($service->image)
                                    <div class="h-48 w-full overflow-hidden bg-gray-100">
                                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
                                    </div>
                                @elseif($service->image_url)
                                    <div class="h-48 w-full overflow-hidden bg-gray-100">
                                        <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
                                    </div>
                                @else
                                    <div class="h-48 w-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                                        <span class="text-4xl text-indigo-300 font-bold opacity-50">{{ substr($service->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                
                                <div class="p-6 flex flex-col flex-grow">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $service->name }}</h3>
                                    <p class="text-gray-600 mb-6 flex-grow text-sm leading-relaxed">{{ Str::limit($service->description, 120) }}</p>
                                    
                                    <div class="flex space-x-3 mt-auto">
                                        <!-- Login Button -->
                                        <a href="{{ $service->login_url ?? \App\Models\Setting::get('min_login_url') ?? 'https://profile.aahaapps.com/' }}" 
                                           target="_blank"
                                           class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2.5 px-4 rounded-lg transition-colors duration-200">
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
                                           class="flex-1 text-center bg-green-500 hover:bg-green-600 text-white text-sm font-semibold py-2.5 px-4 rounded-lg transition-colors duration-200">
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
