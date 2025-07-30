<x-admin-layout>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <a href="{{ route('admin.products.index') }}" 
                   class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors mr-4">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Create New Digital Product</h1>
                    <p class="mt-2 text-sm text-gray-600">Add a new digital product to your store.</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Main Form -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Basic Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
                            <p class="mt-1 text-sm text-gray-600">Enter the basic details of your digital product.</p>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Product Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" 
                                       value="{{ old('title') }}"
                                       placeholder="Enter product title..."
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('title') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">A clear, descriptive title for your product.</p>
                            </div>

                            <!-- Author -->
                            <div>
                                <label for="author" class="block text-sm font-medium text-gray-700 mb-2">
                                    Author
                                </label>
                                <input type="text" name="author" id="author" 
                                       value="{{ old('author') }}"
                                       placeholder="Enter author name..."
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('author') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                @error('author')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">Optional: The author or creator of this digital content.</p>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Description <span class="text-red-500">*</span>
                                </label>
                                <textarea name="description" id="description" rows="6" 
                                          placeholder="Describe your product..."
                                          class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none @error('description') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">Provide a detailed description of your product.</p>
                            </div>

                            <!-- Category & Type -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <!-- Category -->
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Category <span class="text-red-500">*</span>
                                    </label>
                                    <select name="category_id" id="category_id" 
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('category_id') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- File Type -->
                                <div>
                                    <label for="file_type" class="block text-sm font-medium text-gray-700 mb-2">
                                        File Type <span class="text-red-500">*</span>
                                    </label>
                                    <select name="file_type" id="file_type" 
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('file_type') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                        <option value="">Select a file type</option>
                                        <option value="audio" {{ old('file_type') == 'audio' ? 'selected' : '' }}>Audio</option>
                                        <option value="video" {{ old('file_type') == 'video' ? 'selected' : '' }}>Video</option>
                                        <option value="ebook" {{ old('file_type') == 'ebook' ? 'selected' : '' }}>E-Book</option>
                                    </select>
                                    @error('file_type')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Free/Paid Toggle -->
                            <div x-data="{ isFree: {{ old('is_free', false) ? 'true' : 'false' }} }">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Product Type
                                </label>
                                <div class="flex items-center space-x-4">
                                    <button type="button" @click="isFree = false" 
                                            :class="!isFree ? 'bg-blue-600 text-white ring-2 ring-blue-600 ring-offset-2' : 'bg-white text-gray-700 hover:bg-gray-50'"
                                            class="px-4 py-2 rounded-lg border border-gray-300 font-medium text-sm transition-all duration-200">
                                        Paid Resource
                                    </button>
                                    <button type="button" @click="isFree = true" 
                                            :class="isFree ? 'bg-blue-600 text-white ring-2 ring-blue-600 ring-offset-2' : 'bg-white text-gray-700 hover:bg-gray-50'"
                                            class="px-4 py-2 rounded-lg border border-gray-300 font-medium text-sm transition-all duration-200">
                                        Free Resource
                                    </button>
                                    <input type="hidden" name="is_free" :value="isFree ? 1 : 0">
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Choose whether this is a free or paid resource.</p>

                                <!-- Price (shown only for paid resources) -->
                                <div x-show="!isFree" x-transition class="mt-4">
                                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                        Price <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative rounded-lg">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" name="price" id="price" 
                                               step="0.01" min="0" 
                                               value="{{ old('price') }}"
                                               placeholder="0.00"
                                               :required="!isFree"
                                               class="block w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('price') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                    </div>
                                    @error('price')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-2 text-sm text-gray-500">Set a fair price for your digital product.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Files Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Product Files</h3>
                            <p class="mt-1 text-sm text-gray-600">Upload your digital content and preview files.</p>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Main File Upload -->
                            <div x-data="{ 
                                fileName: null,
                                handleFileChange(event) {
                                    const file = event.target.files[0];
                                    this.fileName = file ? file.name : null;
                                }
                            }">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Digital Content File <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                                    <div class="space-y-2 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="text-sm text-gray-600">
                                            <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload your file</span>
                                                <input id="file" name="file" type="file" class="sr-only" @change="handleFileChange($event)">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500" x-text="fileName || 'Audio, video, or document files'"></p>
                                    </div>
                                </div>
                                @error('file')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">This is the main content that customers will receive after purchase.</p>
                            </div>

                            <!-- Preview File Upload -->
                            <div x-data="{ 
                                fileName: null,
                                handleFileChange(event) {
                                    const file = event.target.files[0];
                                    this.fileName = file ? file.name : null;
                                }
                            }">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Preview File
                                </label>
                                <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                                    <div class="space-y-2 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="text-sm text-gray-600">
                                            <label for="preview" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload preview</span>
                                                <input id="preview" name="preview" type="file" class="sr-only" @change="handleFileChange($event)">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500" x-text="fileName || 'Sample or preview content'"></p>
                                    </div>
                                </div>
                                @error('preview')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">Optional preview content for customers to sample before purchase.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Thumbnail & Settings -->
                <div class="space-y-6">
                    <!-- Thumbnail Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Product Thumbnail</h3>
                            <p class="mt-1 text-sm text-gray-600">Upload a thumbnail image for your product.</p>
                        </div>
                        <div class="p-6">
                            <div x-data="{ 
                                imagePreview: null,
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
                                            <label for="thumbnail" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload thumbnail</span>
                                                <input id="thumbnail" name="thumbnail" type="file" accept="image/*" 
                                                       x-ref="fileInput" @change="handleFileChange($event)"
                                                       class="sr-only">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                </div>
                                @error('thumbnail')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">This image will be displayed in product listings and cards.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Product Settings</h3>
                            <p class="mt-1 text-sm text-gray-600">Configure product visibility and features.</p>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Status Toggle -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Product Status
                                </label>
                                <div class="flex items-center" x-data="{ active: {{ old('is_active', 1) ? 'true' : 'false' }} }">
                                    <button type="button" @click="active = !active" 
                                            :class="active ? 'bg-blue-600' : 'bg-gray-200'"
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        <span :class="active ? 'translate-x-5' : 'translate-x-0'"
                                              class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                    </button>
                                    <input type="hidden" name="is_active" :value="active ? 1 : 0">
                                    <span class="ml-3 text-sm text-gray-700" x-text="active ? 'Active - Product will be visible in store' : 'Inactive - Product will be hidden'"></span>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Control whether this product is visible to customers.</p>
                            </div>

                            <!-- Featured Toggle -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Featured Product
                                </label>
                                <div class="flex items-center" x-data="{ featured: {{ old('is_featured', 0) ? 'true' : 'false' }} }">
                                    <button type="button" @click="featured = !featured" 
                                            :class="featured ? 'bg-blue-600' : 'bg-gray-200'"
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        <span :class="featured ? 'translate-x-5' : 'translate-x-0'"
                                              class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                    </button>
                                    <input type="hidden" name="is_featured" :value="featured ? 1 : 0">
                                    <span class="ml-3 text-sm text-gray-700" x-text="featured ? 'Featured - Will be highlighted in store' : 'Not Featured'"></span>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Feature this product to give it more visibility.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 px-6 py-4">
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.products.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Create Product
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