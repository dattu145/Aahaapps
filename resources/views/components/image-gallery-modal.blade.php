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

    <!-- Backdrop - Click outside to close -->
    <div class="fixed inset-0 bg-black/90 backdrop-blur-sm transition-opacity"
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
         x-on:click.stop="">

        <!-- Gallery Container - Centered but with proper positioning context -->
        <div class="relative w-full max-w-6xl flex items-center justify-center">
            
            <!-- Prev Button - Positioned at left edge of the gallery container -->
            <template x-if="images.length > 1">
                <button type="button" 
                        x-on:click.stop="prev()" 
                        class="absolute left-0 -translate-x-full md:left-2 md:translate-x-0 top-1/2 -translate-y-1/2 z-50 p-3 md:p-4 rounded-full bg-white text-black hover:bg-gray-200 transition-all focus:outline-none shadow-[0_0_20px_rgba(0,0,0,0.5)] hover:scale-110"
                        style="left: 0 !important;">
                    <span class="sr-only">Previous</span>
                    <svg class="h-6 w-6 md:h-8 md:w-8" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </template>

            <!-- Image Container -->
            <div class="relative bg-transparent max-w-4xl w-full">
                <!-- Close Button -->
                <button type="button" 
                        x-on:click="close()" 
                        class="absolute -top-10 -right-2 md:-right-4 z-50 p-2 text-white/70 hover:text-white transition-colors focus:outline-none">
                    <span class="sr-only">Close</span>
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Main Image Display -->
                <div class="relative bg-neutral-900/50 rounded-xl overflow-hidden shadow-2xl ring-1 ring-white/10 aspect-video md:aspect-[16/10] w-full flex items-center justify-center">
                    <img :src="activeImage" 
                         class="max-w-full max-h-[80vh] object-contain" 
                         alt="Gallery Preview">
                </div>
                
                <!-- Counter -->
                <div class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-white/50 text-sm font-medium tracking-wide">
                    <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                </div>
            </div>

            <!-- Next Button - Positioned at right edge of the gallery container -->
            <template x-if="images.length > 1">
                <button type="button" 
                        x-on:click.stop="next()" 
                        class="absolute right-0 md:right-2 top-1/2 -translate-y-1/2 z-50 p-3 md:p-4 rounded-full bg-white text-black hover:bg-gray-200 transition-all focus:outline-none shadow-[0_0_20px_rgba(0,0,0,0.5)] hover:scale-110"
                        style="right: 0.5rem !important;">
                    <span class="sr-only">Next</span>
                    <svg class="h-6 w-6 md:h-8 md:w-8" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </template>
        </div>
    </div>
</div>