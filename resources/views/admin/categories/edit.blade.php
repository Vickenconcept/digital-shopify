<x-admin-layout>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <a href="{{ route('admin.categories.index') }}" 
                   class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors mr-4">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Edit Category</h1>
                            <p class="mt-2 text-sm text-gray-600">Update the details for "{{ $category->name }}" category.</p>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500">Category ID: <span class="font-mono">#{{ $category->id }}</span></div>
                            <div class="text-sm text-gray-500">Created: {{ $category->created_at->format('M d, Y') }}</div>
                            <div class="text-sm text-gray-500">Products: {{ $category->digital_products_count ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ submitting: false }" @submit="submitting = true">
            @csrf
            @method('PUT')

            <!-- Main Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Category Information</h3>
                    <p class="mt-1 text-sm text-gray-600">Update the details for this category.</p>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Category Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" 
                               value="{{ old('name', $category->name) }}"
                               placeholder="Enter category name..."
                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('name') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">A unique, descriptive name for your category.</p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="4" 
                                  placeholder="Describe what this category contains..."
                                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-none @error('description') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Optional description to help users understand this category.</p>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Category Image
                        </label>
                        <div class="mt-2" x-data="{ 
                            imagePreview: '{{ $category->image_path ?: null }}',
                            currentImage: '{{ $category->image_path ?: null }}',
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
                                $refs.fileInput.value = '';
                            }
                        }">
                            <!-- Current/Preview Image -->
                            <div class="mb-4" x-show="imagePreview" x-cloak>
                                <div class="relative inline-block">
                                    <img :src="imagePreview" alt="Category image" class="h-32 w-32 object-cover rounded-lg border-2 border-gray-200">
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

                            <!-- File Input -->
                            <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                                <div class="space-y-2 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="text-sm text-gray-600">
                                        <label for="image_path" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-500 hover:text-orange-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span x-show="!currentImage">Upload an image</span>
                                            <span x-show="currentImage">Replace image</span>
                                            <input id="image_path" name="image_path" type="file" accept="image/*" 
                                                   x-ref="fileInput" @change="handleFileChange($event)"
                                                   class="sr-only">
                                        </label>
                                        <span class="pl-1">or drag and drop</span>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                </div>
                            </div>
                        </div>
                        @error('image_path')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">
                            @if($category->image_path)
                                Update the category image or leave empty to keep the current image.
                            @else
                                Add an optional image to represent this category.
                            @endif
                        </p>
                    </div>

                    <!-- Status Toggle -->
<div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Category Status
                        </label>
                        <div class="flex items-center" x-data="{ active: {{ old('is_active', $category->is_active) ? 'true' : 'false' }} }">
                            <button type="button" @click="active = !active" 
                                    :class="active ? 'bg-orange-500' : 'bg-gray-200'"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                                <span :class="active ? 'translate-x-5' : 'translate-x-0'"
                                      class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                            <input type="hidden" name="is_active" :value="active ? 1 : 0">
                            <span class="ml-3 text-sm text-gray-700" x-text="active ? 'Active - Category will be visible to users' : 'Inactive - Category will be hidden from users'"></span>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Control whether this category is visible in the public store.</p>
                    </div>
                </div>
            </div>

            <!-- Category Statistics -->
            @if($category->digitalProducts()->count() > 0)
                <div class="bg-orange-50 rounded-xl border border-orange-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-orange-800">Category Usage</h3>
                            <div class="mt-2 text-sm text-orange-700">
                                <p>This category contains <strong>{{ $category->digitalProducts()->count() }}</strong> {{ Str::plural('product', $category->digitalProducts()->count()) }}.</p>
                                @if(!$category->is_active)
                                    <p class="mt-1 font-medium">⚠️ This category is currently inactive, so products won't be visible to customers.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            @if($category->digitalProducts()->count() == 0)
                                <span class="inline-flex items-center px-4 py-2 border border-red-300 rounded-lg shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 cursor-pointer"
                                      onclick="document.getElementById('delete-category-form').submit();">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Category
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-500 bg-gray-50 cursor-not-allowed">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                                    </svg>
                                    Cannot Delete (Has Products)
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.categories.index') }}" 
                           class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </a>
                        <button type="submit" 
                                :disabled="submitting"
                                :class="submitting ? 'opacity-50 cursor-not-allowed' : ''"
                                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                            <!-- Loading Spinner -->
                            <svg x-show="submitting" class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <!-- Save Icon (when not loading) -->
                            <svg x-show="!submitting" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span x-text="submitting ? 'Updating Category...' : 'Update Category'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
</div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <!-- Delete Form -->
    @if($category->digitalProducts()->count() == 0)
        <form id="delete-category-form" action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-admin-layout>