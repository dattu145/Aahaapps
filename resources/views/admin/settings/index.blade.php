<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6" x-data="logoUploader()">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Logo Management</label>

                            <!-- Image Preview Area -->
                            <div class="mb-4">
                                <template x-if="imagePreview">
                                    <div class="relative w-full max-w-sm border rounded-lg overflow-hidden group">
                                        <img :src="imagePreview" id="previewImage" class="max-h-64 mx-auto block display-block">
                                        <div class="absolute top-2 right-2 flex space-x-2">
                                            <button type="button" @click="clearImage" class="bg-red-500 text-white p-1 rounded hover:bg-red-600 shadow-sm" title="Remove">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                                
                                <template x-if="!imagePreview">
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center text-gray-500 bg-gray-50 h-40">
                                        <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-sm">No new logo selected</span>
                                    </div>
                                </template>
                            </div>

                            <!-- Inputs -->
                            <div class="space-y-4">
                                <!-- File Upload -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Upload File</label>
                                    <input type="file" name="logo" id="logo" accept="image/*" @change="handleFileUpload" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors">
                                </div>
                                
                                <!-- Logo Dimensions -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="logo_height" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Logo Height (px)</label>
                                        <input type="number" name="logo_height" id="logo_height" value="{{ $logo_height ?? '40' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="40">
                                    </div>
                                    <div>
                                        <label for="logo_width" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Logo Width (px/auto)</label>
                                        <input type="text" name="logo_width" id="logo_width" value="{{ $logo_width ?? 'auto' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="auto">
                                    </div>
                                </div>

                                <!-- URL Input -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Or Image URL</label>
                                    <input type="url" name="logo_url" x-model="imageUrl" @input.debounce.500ms="handleUrlInput" placeholder="https://example.com/logo.png" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                </div>

                                <!-- WhatsApp Number -->
                                <div>
                                    <label for="whatsapp_number" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">WhatsApp Number</label>
                                    <input type="text" name="whatsapp_number" id="whatsapp_number" value="{{ $whatsapp_number ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="e.g. 919876543210">
                                    <p class="text-xs text-gray-400 mt-1">Enter number with country code (without +)</p>
                                </div>
                                
                                <div class="pt-6 border-t border-gray-100">
                                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Social Media & Contact</h3>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label for="social_email" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Email Address</label>
                                            <input type="email" name="social_email" id="social_email" value="{{ $social_email ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="contact@example.com">
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="social_linkedin" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">LinkedIn URL</label>
                                                <input type="url" name="social_linkedin" id="social_linkedin" value="{{ $social_linkedin ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="https://linkedin.com/in/...">
                                            </div>
                                            <div>
                                                <label for="social_web" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Website URL</label>
                                                <input type="url" name="social_web" id="social_web" value="{{ $social_web ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="https://example.com">
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <div class="flex justify-between items-center mb-1">
                                                <label for="company_address" class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Company Address</label>
                                                
                                                <div class="flex items-center gap-2">
                                                    <label for="company_address_size" class="text-xs font-medium text-gray-400 uppercase tracking-wider">Font Size (px)</label>
                                                    <input type="number" name="company_address_size" id="company_address_size" value="{{ $company_address_size ?? '12' }}" class="w-16 h-7 text-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="12" min="8" max="50">
                                                </div>
                                            </div>
                                            <textarea name="company_address" id="company_address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Enter full address...">{{ $company_address ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Current Logo Display (Server Side) -->
                            @if($logo)
                                <div class="mt-6 border-t pt-4">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Current Active Logo</p>
                                    <div class="bg-gray-100 p-2 rounded inline-block">
                                        <img src="{{ asset('storage/' . $logo) }}" alt="Current Logo" class="h-12 w-auto object-contain">
                                    </div>
                                </div>
                            @elseif(isset($logo_url) && $logo_url)
                                <div class="mt-6 border-t pt-4">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Current Active Logo (URL)</p>
                                    <div class="bg-gray-100 p-2 rounded inline-block">
                                        <img src="{{ $logo_url }}" alt="Current Logo" class="h-12 w-auto object-contain">
                                    </div>
                                </div>
                            @endif
                        </div>


                        {{-- Update Button with Click Handler --}}
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save Settings') }}</x-primary-button>
                        </div>
                    </form>
                    
                        <script>
                            function logoUploader() {
                                return {
                                    imagePreview: null,
                                    imageUrl: @json($logo_url ?? ''),
                                    
                                    init() { },

                                    handleFileUpload(event) {
                                        const file = event.target.files[0];
                                        if (file) {
                                            const reader = new FileReader();
                                            reader.onload = (e) => {
                                                this.imagePreview = e.target.result;
                                                this.imageUrl = ''; 
                                            };
                                            reader.readAsDataURL(file);
                                        }
                                    },
                                    
                                    handleUrlInput() {
                                        if (this.imageUrl) {
                                            this.imagePreview = this.imageUrl;
                                            document.getElementById('logo').value = ''; 
                                        } else {
                                            this.imagePreview = null;
                                        }
                                    },
                                    
                                    clearImage() {
                                        this.imagePreview = null;
                                        this.imageUrl = '';
                                        document.getElementById('logo').value = '';
                                    }
                                }
                            }
                        </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
