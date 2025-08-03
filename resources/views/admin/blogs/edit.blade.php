<x-admin-layout>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('admin.blogs.index') }}" 
                       class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors mr-4">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Edit Blog Post</h1>
                        <p class="mt-2 text-sm text-gray-600">Update your blog post details.</p>
                    </div>
                </div>
                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this post?')"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete Post
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-lg bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-lg bg-red-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Main Form -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Basic Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
                            <p class="mt-1 text-sm text-gray-600">Update the basic details of your blog post.</p>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Post Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" 
                                       value="{{ old('title', $blog->title) }}"
                                       placeholder="Enter post title..."
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('title') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">A clear, descriptive title for your blog post.</p>
                            </div>

                            <!-- Excerpt -->
                            <div>
                                <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                                    Excerpt
                                </label>
                                <textarea name="excerpt" id="excerpt" rows="3"
                                          placeholder="Enter a brief excerpt..."
                                          class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-none @error('excerpt') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('excerpt', $blog->excerpt) }}</textarea>
                                @error('excerpt')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">A short summary of your blog post.</p>
                            </div>

                            <!-- Content -->
                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                    Content <span class="text-red-500">*</span>
                                </label>
                                <textarea name="content" id="content" rows="12"
                                          placeholder="Write your blog post content..."
                                          class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-none @error('content') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('content', $blog->content) }}</textarea>
                                @error('content')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">The main content of your blog post.</p>
                            </div>

                            <!-- YouTube URL -->
                            <div>
                                <label for="youtube_url" class="block text-sm font-medium text-gray-700 mb-2">
                                    YouTube URL
                                </label>
                                <input type="url" name="youtube_url" id="youtube_url" 
                                       value="{{ old('youtube_url', $blog->youtube_url) }}"
                                       placeholder="Enter YouTube video URL..."
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('youtube_url') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                @error('youtube_url')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">Optional: Add a related YouTube video to your post.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Featured Image & Settings -->
                <div class="space-y-6">
                    <!-- Featured Image Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Featured Image</h3>
                            <p class="mt-1 text-sm text-gray-600">Update the featured image for your blog post.</p>
                        </div>
                        <div class="p-6">
                            <div x-data="{ 
                                imagePreview: '{{ $blog->featured_image ? Storage::url($blog->featured_image) : null }}',
                                handleFileChange(event) {
                                    const file = event.target.files[0];
                                    if (file) {
                                        const reader = new FileReader();
                                        reader.onload = (e) => {
                                            this.imagePreview = e.target.result;
                                        };
                                        reader.readAsDataURL(file);
                                    } else {
                                        this.imagePreview = null;
                                    }
                                }
                            }">
                                <!-- Image Preview -->
                                <div class="mb-4" x-show="imagePreview" x-cloak>
                                    <div class="relative">
                                        <img :src="imagePreview" alt="Preview" class="w-full aspect-video object-cover rounded-lg border-2 border-gray-200">
                                        <button type="button" @click="imagePreview = null; $refs.fileInput.value = ''" 
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- File Input -->
                                <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                                    <div class="space-y-2 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="text-sm text-gray-600">
                                            <label for="featured_image" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-500 hover:text-orange-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                                <span>Upload image</span>
                                                <input id="featured_image" name="featured_image" type="file" accept="image/*" 
                                                       x-ref="fileInput" @change="handleFileChange($event)"
                                                       class="sr-only">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                </div>
                                @error('featured_image')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">This image will be displayed at the top of your blog post.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Post Settings</h3>
                            <p class="mt-1 text-sm text-gray-600">Configure post visibility and features.</p>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Published Toggle -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Publication Status
                                </label>
                                <div class="flex items-center" x-data="{ published: {{ old('is_published', $blog->is_published) ? 'true' : 'false' }} }">
                                    <button type="button" @click="published = !published" 
                                            :class="published ? 'bg-orange-500' : 'bg-gray-200'"
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                                        <span :class="published ? 'translate-x-5' : 'translate-x-0'"
                                              class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                    </button>
                                    <input type="hidden" name="is_published" :value="published ? 1 : 0">
                                    <span class="ml-3 text-sm text-gray-700" x-text="published ? 'Published - Post is visible to readers' : 'Draft - Post is hidden'"></span>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Control whether this post is visible to readers.</p>
                            </div>

                            <!-- Featured Toggle -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Featured Post
                                </label>
                                <div class="flex items-center" x-data="{ featured: {{ old('is_featured', $blog->is_featured) ? 'true' : 'false' }} }">
                                    <button type="button" @click="featured = !featured" 
                                            :class="featured ? 'bg-orange-500' : 'bg-gray-200'"
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                                        <span :class="featured ? 'translate-x-5' : 'translate-x-0'"
                                              class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                    </button>
                                    <input type="hidden" name="is_featured" :value="featured ? 1 : 0">
                                    <span class="ml-3 text-sm text-gray-700" x-text="featured ? 'Featured - Will be highlighted on homepage' : 'Not Featured'"></span>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Feature this post to give it more visibility.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 px-6 py-4">
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.blogs.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Post
                    </button>
                </div>
            </div>
        </form>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</x-admin-layout>