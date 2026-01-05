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
    <div class="fixed inset-0 z-10 overflow-y-auto p-4">
        <div class="flex min-h-full items-center justify-center">
            
            <!-- Gallery Container - Much Smaller and centered -->
            <div class="relative w-full max-w-2xl mx-auto"
                 x-show="isOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 x-on:click.stop="">

                <!-- Close Button - Top Right Corner of Gallery -->
                <button type="button" 
                        x-on:click="close()" 
                        class="absolute -top-3 -right-3 z-50 p-2 rounded-full bg-black/80 text-white hover:bg-white hover:text-black transition-colors focus:outline-none border-2 border-white/20">
                    <span class="sr-only">Close</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Image Container - Small size -->
                <div class="relative bg-neutral-900 rounded-lg shadow-2xl overflow-hidden aspect-[4/3] w-full">
                    <!-- Navigation Arrows - Center vertically -->
                    <template x-if="images.length > 1">
                        <div class="contents">
                            <!-- Prev Button -->
                            <button x-on:click.stop="prev()" 
                                    class="absolute left-2 top-1/2 -translate-y-1/2 z-40 p-2 rounded-full bg-black/70 text-white hover:bg-white hover:text-black transition-colors focus:outline-none border border-white/20">
                                <span class="sr-only">Previous</span>
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <!-- Next Button -->
                            <button x-on:click.stop="next()" 
                                    class="absolute right-2 top-1/2 -translate-y-1/2 z-40 p-2 rounded-full bg-black/70 text-white hover:bg-white hover:text-black transition-colors focus:outline-none border border-white/20">
                                <span class="sr-only">Next</span>
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </template>

                    <!-- Image -->
                    <div class="w-full h-full flex items-center justify-center bg-black p-1">
                        <img :src="activeImage" 
                             class="max-w-full max-h-full object-contain rounded" 
                             alt="Gallery Preview">
                    </div>

                    <!-- Page Counter - Bottom Center -->
                    <div class="absolute bottom-2 left-1/2 -translate-x-1/2 bg-black/70 px-3 py-1 rounded-full text-white text-xs font-medium backdrop-blur-sm z-30 border border-white/20">
                        <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>