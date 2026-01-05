<div x-data="{
    isOpen: false,
    images: [],
    currentIndex: 0,
    
    init() {
        window.addEventListener('open-gallery', (e) => {
            this.images = e.detail.images;
            this.currentIndex = e.detail.index || 0;
            this.isOpen = true;
            document.body.classList.add('overflow-hidden');
        });
    },

    close() {
        this.isOpen = false;
        document.body.classList.remove('overflow-hidden');
        setTimeout(() => {
            this.images = [];
            this.currentIndex = 0;
        }, 300);
    },

    next() {
        if (this.images.length > 1) {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
        }
    },

    prev() {
        if (this.images.length > 1) {
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
        }
    },

    get activeImage() {
        return this.images[this.currentIndex];
    }
}"
x-on:keydown.escape.window="close()"
class="relative z-[99999]"
aria-labelledby="gallery-modal" 
role="dialog" 
aria-modal="true"
x-show="isOpen"
x-cloak
style="display: none;">

    <!-- Backdrop - Enhanced blur for everything behind -->
    <div class="fixed inset-0 bg-black/30 backdrop-blur-md transition-opacity"
         x-show="isOpen"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-on:click="close()"></div>

    <!-- Main Container -->
    <div class="fixed inset-0 z-10 overflow-y-auto p-4 flex items-center justify-center"
         x-show="isOpen"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         x-on:click="close()">

        <!-- Gallery Container - Centered but with proper positioning context -->
        <div class="relative w-full max-w-6xl flex items-center justify-center"
             x-on:click.stop="">
            
            <!-- Prev Button - Fixed mobile positioning -->
            <template x-if="images.length > 1">
                <button type="button" 
                        x-on:click.stop="prev()" 
                        class="absolute left-2 md:left-2 top-1/2 -translate-y-1/2 z-50 p-3 md:p-5 rounded-full bg-white text-black hover:bg-gray-200 transition-all focus:outline-none shadow-[0_0_25px_rgba(0,0,0,0.7)] hover:scale-110"
                        style="left: 0.5rem !important;">
                    <span class="sr-only">Previous</span>
                    <svg class="h-6 w-6 md:h-9 md:w-9" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </template>

            <!-- Image Container -->
            <div class="relative bg-transparent max-w-4xl w-full">
                <!-- Close Button - Enhanced with red background and more padding -->
                <button type="button" 
                        x-on:click="close()" 
                        class="absolute -top-12 -right-2 md:-top-14 md:-right-6 z-50 p-3 md:p-3.5 bg-black text-white hover:bg-white hover:text-black backdrop-blur-md transition-all duration-200 focus:outline-none rounded-xl shadow-lg hover:shadow-xl hover:scale-105 border-2 border-white/30 hover:border-white/50">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6 md:h-8 md:w-8" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Main Image Display with enhanced background blur -->
                <div class="relative bg-black/40 backdrop-blur-lg rounded-xl overflow-hidden shadow-2xl ring-2 ring-white/30 aspect-video md:aspect-[16/10] w-full flex items-center justify-center">
                    <img :src="activeImage" 
                         class="max-w-full max-h-[80vh] object-contain" 
                         alt="Gallery Preview">
                </div>
                
                <!-- Counter -->
                <div class="absolute -bottom-10 md:-bottom-12 left-1/2 -translate-x-1/2 text-white/80 text-sm font-semibold tracking-wide bg-black/50 backdrop-blur-md px-3 py-1.5 md:px-4 md:py-2 rounded-full border border-white/20">
                    <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                </div>
            </div>

            <!-- Next Button - Fixed mobile positioning -->
            <template x-if="images.length > 1">
                <button type="button" 
                        x-on:click.stop="next()" 
                        class="absolute right-2 md:right-2 top-1/2 -translate-y-1/2 z-50 p-3 md:p-5 rounded-full bg-white text-black hover:bg-gray-200 transition-all focus:outline-none shadow-[0_0_25px_rgba(0,0,0,0.7)] hover:scale-110"
                        style="right: 0.5rem !important;">
                    <span class="sr-only">Next</span>
                    <svg class="h-6 w-6 md:h-9 md:w-9" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </template>
        </div>
    </div>
</div>