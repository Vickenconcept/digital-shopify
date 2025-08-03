<x-admin-layout>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Site Settings</h1>
                    <p class="mt-2 text-sm text-gray-600">Manage your site's content and appearance.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Weekly Theme Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Weekly Theme</h3>
                    <p class="mt-1 text-sm text-gray-600">Set up your weekly spiritual focus and daily messages.</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Theme Title -->
                    <div>
                        <label for="weekly_theme_title" class="block text-sm font-medium text-gray-700 mb-2">
                            Theme Title
                        </label>
                        <input type="text" name="weekly_theme_title" id="weekly_theme_title"
                               value="{{ old('weekly_theme_title', $settings->weekly_theme_title) }}"
                               placeholder="E.g., Living That Spiritual Life – Awakening Your Spirit"
                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                        <p class="mt-2 text-sm text-gray-500">The main title for your weekly theme.</p>
                    </div>

                    <!-- Theme Description -->
                    <div>
                        <label for="weekly_theme_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Theme Description
                        </label>
                        <textarea name="weekly_theme_description" id="weekly_theme_description" rows="4"
                                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-none">{{ old('weekly_theme_description', $settings->weekly_theme_description) }}</textarea>
                        <p class="mt-2 text-sm text-gray-500">A brief description of this week's spiritual focus.</p>
                    </div>

                    <!-- Theme Start Date -->
                    <div>
                        <label for="weekly_theme_start_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Theme Start Date
                        </label>
                        <input type="date" name="weekly_theme_start_date" id="weekly_theme_start_date"
                               value="{{ old('weekly_theme_start_date', $settings->weekly_theme_start_date?->format('Y-m-d')) }}"
                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                        <p class="mt-2 text-sm text-gray-500">When this theme should start being displayed.</p>
                    </div>

                    <!-- Daily Messages -->
                    <div class="space-y-4">
                        <h4 class="font-medium text-gray-900">Daily Messages</h4>
                        @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                            <div>
                                <label for="{{ $day }}_message" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ ucfirst($day) }}'s Message
                                </label>
                                <textarea name="{{ $day }}_message" id="{{ $day }}_message" rows="3"
                                          class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-none">{{ old($day.'_message', $settings->{$day.'_message'}) }}</textarea>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Call to Action Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Call to Action</h3>
                    <p class="mt-1 text-sm text-gray-600">Configure your site's main call-to-action section.</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- CTA Title -->
                    <div>
                        <label for="cta_title" class="block text-sm font-medium text-gray-700 mb-2">
                            CTA Title
                        </label>
                        <input type="text" name="cta_title" id="cta_title"
                               value="{{ old('cta_title', $settings->cta_title) }}"
                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>

                    <!-- CTA Description -->
                    <div>
                        <label for="cta_description" class="block text-sm font-medium text-gray-700 mb-2">
                            CTA Description
                        </label>
                        <textarea name="cta_description" id="cta_description" rows="3"
                                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-none">{{ old('cta_description', $settings->cta_description) }}</textarea>
                    </div>

                    <!-- CTA Button -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="cta_button_text" class="block text-sm font-medium text-gray-700 mb-2">
                                Button Text
                            </label>
                            <input type="text" name="cta_button_text" id="cta_button_text"
                                   value="{{ old('cta_button_text', $settings->cta_button_text) }}"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                        </div>
                        <div>
                            <label for="cta_button_link" class="block text-sm font-medium text-gray-700 mb-2">
                                Button Link
                            </label>
                            <input type="text" name="cta_button_link" id="cta_button_link"
                                   value="{{ old('cta_button_link', $settings->cta_button_link) }}"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Social Media Links</h3>
                    <p class="mt-1 text-sm text-gray-600">Connect your social media profiles.</p>
                </div>
                <div class="p-6 space-y-6">
                    @foreach(['facebook', 'twitter', 'instagram', 'youtube', 'tiktok'] as $social)
                        <div>
                            <label for="{{ $social }}_link" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ ucfirst($social) }} Link
                            </label>
                            <input type="url" name="{{ $social }}_link" id="{{ $social }}_link"
                                   value="{{ old($social.'_link', $settings->{$social.'_link'}) }}"
                                   placeholder="https://"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Images Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Site Images</h3>
                    <p class="mt-1 text-sm text-gray-600">Manage your hero and banner images.</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Hero Images -->
                    <div>
                        <h4 class="font-medium text-gray-900 mb-4">Hero Images</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @for($i = 1; $i <= 3; $i++)
                                <div x-data="{ 
                                    imagePreview: '{{ $settings->{"hero_image_$i"} ? asset("storage/" . $settings->{"hero_image_$i"}) : null }}',
                                    currentImage: '{{ $settings->{"hero_image_$i"} ? asset("storage/" . $settings->{"hero_image_$i"}) : null }}',
                                    handleFileChange(event) {
                                        const file = event.target.files[0];
                                        if (file) {
                                            const reader = new FileReader();
                                            reader.onload = (e) => {
                                                this.imagePreview = e.target.result;
                                            };
                                            reader.readAsDataURL(file);
                                        } else {
                                            this.imagePreview = this.currentImage;
                                        }
                                    },
                                    removeImage() {
                                        this.imagePreview = null;
                                        this.currentImage = null;
                                        $refs.fileInput{{ $i }}.value = '';
                                    }
                                }">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Hero Image {{ $i }}
                                    </label>

                                    <!-- Image Preview -->
                                    <div class="mb-4" x-show="imagePreview" x-cloak>
                                        <div class="relative">
                                            <img :src="imagePreview" alt="Hero {{ $i }}" 
                                                 class="w-full aspect-video object-cover rounded-lg border-2 border-gray-200">
                                            <button type="button" @click="removeImage()" 
                                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="mt-2 text-xs text-gray-500">
                                            <span x-show="currentImage && imagePreview === currentImage">Current image</span>
                                            <span x-show="imagePreview !== currentImage">New image preview</span>
                                        </p>
                                    </div>

                                    <!-- File Upload -->
                                    <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                                        <div class="space-y-2 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="text-sm text-gray-600">
                                                <label for="hero_image_{{ $i }}" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-500 hover:text-orange-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                                    <span x-show="!currentImage">Upload image</span>
                                                    <span x-show="currentImage">Replace image</span>
                                                    <input id="hero_image_{{ $i }}" 
                                                           name="hero_image_{{ $i }}" 
                                                           type="file" 
                                                           accept="image/*"
                                                           x-ref="fileInput{{ $i }}"
                                                           @change="handleFileChange($event)"
                                                           class="sr-only">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Banner Images -->
                    <div>
                        <h4 class="font-medium text-gray-900 mb-4">Banner Images</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @for($i = 1; $i <= 3; $i++)
                                <div x-data="{ 
                                    imagePreview: '{{ $settings->{"banner_image_$i"} ? asset("storage/" . $settings->{"banner_image_$i"}) : null }}',
                                    currentImage: '{{ $settings->{"banner_image_$i"} ? asset("storage/" . $settings->{"banner_image_$i"}) : null }}',
                                    handleFileChange(event) {
                                        const file = event.target.files[0];
                                        if (file) {
                                            const reader = new FileReader();
                                            reader.onload = (e) => {
                                                this.imagePreview = e.target.result;
                                            };
                                            reader.readAsDataURL(file);
                                        } else {
                                            this.imagePreview = this.currentImage;
                                        }
                                    },
                                    removeImage() {
                                        this.imagePreview = null;
                                        this.currentImage = null;
                                        $refs.bannerInput{{ $i }}.value = '';
                                    }
                                }">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Banner Image {{ $i }}
                                    </label>

                                    <!-- Image Preview -->
                                    <div class="mb-4" x-show="imagePreview" x-cloak>
                                        <div class="relative">
                                            <img :src="imagePreview" alt="Banner {{ $i }}" 
                                                 class="w-full aspect-video object-cover rounded-lg border-2 border-gray-200">
                                            <button type="button" @click="removeImage()" 
                                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="mt-2 text-xs text-gray-500">
                                            <span x-show="currentImage && imagePreview === currentImage">Current image</span>
                                            <span x-show="imagePreview !== currentImage">New image preview</span>
                                        </p>
                                    </div>

                                    <!-- File Upload -->
                                    <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                                        <div class="space-y-2 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="text-sm text-gray-600">
                                                <label for="banner_image_{{ $i }}" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-500 hover:text-orange-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                                    <span x-show="!currentImage">Upload image</span>
                                                    <span x-show="currentImage">Replace image</span>
                                                    <input id="banner_image_{{ $i }}" 
                                                           name="banner_image_{{ $i }}" 
                                                           type="file" 
                                                           accept="image/*"
                                                           x-ref="bannerInput{{ $i }}"
                                                           @change="handleFileChange($event)"
                                                           class="sr-only">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 px-6 py-4">
                <div class="flex items-center justify-end">
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Save Settings
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>