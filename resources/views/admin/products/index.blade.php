<x-admin-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Digital Products</h1>
                    <p class="mt-2 text-gray-600">Manage your digital content library</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Product
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-50 p-4 border border-green-200">
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

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6" x-data="{ 
            searchTerm: '{{ request('search', '') }}',
            selectedCategory: '{{ request('category', '') }}',
            selectedType: '{{ request('type', '') }}',
            selectedStatus: '{{ request('status', '') }}',
            selectedFeatured: '{{ request('featured', '') }}',
            sortBy: '{{ request('sort', 'latest') }}',
            applyFilters() {
                const params = new URLSearchParams();
                if (this.searchTerm) params.append('search', this.searchTerm);
                if (this.selectedCategory) params.append('category', this.selectedCategory);
                if (this.selectedType) params.append('type', this.selectedType);
                if (this.selectedStatus !== '') params.append('status', this.selectedStatus);
                if (this.selectedFeatured !== '') params.append('featured', this.selectedFeatured);
                if (this.sortBy) params.append('sort', this.sortBy);
                window.location.href = `${window.location.pathname}?${params.toString()}`;
            },
            clearFilters() {
                this.searchTerm = '';
                this.selectedCategory = '';
                this.selectedType = '';
                this.selectedStatus = '';
                this.selectedFeatured = '';
                this.sortBy = 'latest';
                window.location.href = window.location.pathname;
            }
        }">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Search & Filter Products</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                    <!-- Search Input -->
                    <div class="lg:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <div class="relative">
                            <input type="text" 
                                   x-model="searchTerm" 
                                   @keyup.enter="applyFilters()"
                                   placeholder="Title, description, or author..." 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select x-model="selectedCategory" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Type Filter -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select x-model="selectedType" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                            <option value="">All Types</option>
                            @foreach($availableTypes as $type)
                                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select x-model="selectedStatus" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <!-- Sort Filter -->
<div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <select x-model="sortBy" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                            <option value="latest">Latest</option>
                            <option value="oldest">Oldest</option>
                            <option value="title">Title (A-Z)</option>
                            <option value="price_low">Price (Low-High)</option>
                            <option value="price_high">Price (High-Low)</option>
                        </select>
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="mt-4 flex flex-wrap gap-3">
                    <button @click="applyFilters()" 
                            class="inline-flex items-center px-4 py-2 bg-orange-500 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z" />
                        </svg>
                        Apply Filters
                    </button>
                    
                    <button @click="clearFilters()" 
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Clear All
                    </button>
                </div>

                <!-- Active Filters Display -->
                @if(request()->hasAny(['search', 'category', 'type', 'status', 'featured', 'sort']))
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="text-sm font-medium text-gray-700">Active filters:</span>
                        @if(request('search'))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                Search: "{{ request('search') }}"
                            </span>
                        @endif
                        @if(request('category'))
                            @php
                                $categoryName = $categories->firstWhere('id', request('category'))->name ?? 'Unknown';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Category: {{ $categoryName }}
                            </span>
                        @endif
                        @if(request('type'))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                Type: {{ ucfirst(request('type')) }}
                            </span>
                        @endif
                        @if(request('status') !== null && request('status') !== '')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Status: {{ request('status') == '1' ? 'Active' : 'Inactive' }}
                            </span>
                        @endif
                        @if(request('sort') && request('sort') !== 'latest')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                Sort: {{ ucfirst(str_replace('_', ' ', request('sort'))) }}
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Products List -->
        @if($products->count() > 0)
            <!-- Summary -->
            <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-700">
                        Showing <span class="font-medium">{{ $products->firstItem() }}</span> to <span class="font-medium">{{ $products->lastItem() }}</span> of <span class="font-medium">{{ $products->total() }}</span> products
                    </p>
                    <div class="flex items-center space-x-2" x-data="{ 
                        viewMode: '{{ request('view', 'grid') }}',
                        switchView(mode) {
                            const params = new URLSearchParams(window.location.search);
                            params.set('view', mode);
                            window.location.href = `${window.location.pathname}?${params.toString()}`;
                        }
                    }">
                        <span class="text-sm text-gray-500">View:</span>
                        <div class="flex rounded-lg border border-gray-200 p-1 bg-white">
                            <button @click="switchView('grid')" 
                                    :class="viewMode === 'grid' ? 'bg-orange-500 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                                    class="p-1.5 rounded-md transition-all duration-200" 
                                    title="Grid View">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                            </button>
                            <button @click="switchView('table')" 
                                    :class="viewMode === 'table' ? 'bg-orange-500 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                                    class="p-1.5 rounded-md transition-all duration-200" 
                                    title="Table View">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Display -->
            @php $viewMode = request('view', 'grid'); @endphp
            
            @if($viewMode === 'grid')
                <!-- Grid View -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                    @foreach($products as $product)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-shadow duration-200 overflow-hidden">
                            <!-- Product Image/Thumbnail -->
                            <div class="relative h-48 bg-gradient-to-br from-gray-100 to-gray-200">
                                @if($product->thumbnail_path)
                                    <img src="{{ $product->thumbnail_path }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            @if($product->file_type === 'audio')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                            @elseif($product->file_type === 'video')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            @endif
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Status Badges -->
                                <div class="absolute top-3 left-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($product->file_type === 'audio') bg-green-100 text-green-800
                                        @elseif($product->file_type === 'video') bg-red-100 text-red-800
                                        @else bg-orange-100 text-orange-800
                                        @endif">
                                        {{ ucfirst($product->file_type) }}
                                    </span>
</div>

                                <div class="absolute top-3 right-3 flex space-x-1">
                                    @if($product->is_featured)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Featured
                                        </span>
                                    @endif
                                    <!-- Status Toggle -->
                                    <button x-data="{ 
                                        isActive: {{ $product->is_active ? 'true' : 'false' }},
                                        updating: false,
                                        async toggleStatus() {
                                            if (this.updating) return;
                                            this.updating = true;
                                            try {
                                                const response = await fetch('/admin/products/{{ $product->id }}/toggle-status', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                    }
                                                });
                                                const data = await response.json();
                                                if (data.success) {
                                                    this.isActive = data.is_active;
                                                } else {
                                                    alert('Failed to update status');
                                                }
                                            } catch (error) {
                                                alert('Error updating status');
                                            } finally {
                                                this.updating = false;
                                            }
                                        }
                                    }" @click="toggleStatus()" :disabled="updating"
                                    :class="isActive ? 'bg-green-100 text-green-800 hover:bg-green-200 border-green-300' : 'bg-red-100 text-red-800 hover:bg-red-200 border-red-300'"
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 cursor-pointer border-2 hover:shadow-sm active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                                    title="Click to toggle status">
                                        <span class="mr-1" x-text="updating ? '⏳' : (isActive ? '✓' : '✕')"></span>
                                        <span x-text="updating ? 'Updating...' : (isActive ? 'Active' : 'Inactive')"></span>
                                    </button>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="p-6">
                                <div class="flex-1 min-h-0">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $product->title }}</h3>
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description, 100) }}</p>
                                    
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            @if($product->category)
                                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ $product->category->name }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            @if($product->is_free)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Free Resource
                                                </span>
                                            @else
                                                <p class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</p>
                                            @endif
                                            <p class="text-xs text-gray-500">by {{ $product->user->name }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-orange-500 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                                        <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to delete this product?')"
                                                class="w-full inline-flex items-center justify-center px-3 py-2 bg-red-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                            <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Table View -->
                <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden mb-8">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($products as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-12 w-12 flex-shrink-0">
                                                    @if($product->thumbnail_path)
                                                        <img class="h-12 w-12 rounded-lg object-cover" src="{{ $product->thumbnail_path }}" alt="{{ $product->title }}">
                                                    @else
                                                        <div class="h-12 w-12 rounded-lg bg-gray-200 flex items-center justify-center">
                                                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                @if($product->file_type === 'audio')
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                                @elseif($product->file_type === 'video')
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                                @else
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                                @endif
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ Str::limit($product->title, 50) }}</div>
                                                    <div class="text-sm text-gray-500">{{ Str::limit($product->description, 60) }}</div>
                                                    @if($product->is_featured)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">
                                                            Featured
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $product->category->name ?? 'No Category' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($product->file_type === 'audio') bg-green-100 text-green-800
                                                @elseif($product->file_type === 'video') bg-red-100 text-red-800
                                                @else bg-orange-100 text-orange-800
                                                @endif">
                                                {{ ucfirst($product->file_type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($product->is_free)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Free Resource
                                                </span>
                                            @else
                                                <span class="text-sm font-medium text-gray-900">${{ number_format($product->price, 2) }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $product->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button x-data="{ 
                                                isActive: {{ $product->is_active ? 'true' : 'false' }},
                                                updating: false,
                                                async toggleStatus() {
                                                    if (this.updating) return;
                                                    this.updating = true;
                                                    try {
                                                        const response = await fetch('/admin/products/{{ $product->id }}/toggle-status', {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/json',
                                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                            }
                                                        });
                                                        const data = await response.json();
                                                        if (data.success) {
                                                            this.isActive = data.is_active;
                                                        } else {
                                                            alert('Failed to update status');
                                                        }
                                                    } catch (error) {
                                                        alert('Error updating status');
                                                    } finally {
                                                        this.updating = false;
                                                    }
                                                }
                                            }" @click="toggleStatus()" :disabled="updating"
                                            :class="isActive ? 'bg-green-100 text-green-800 hover:bg-green-200 border-green-300' : 'bg-red-100 text-red-800 hover:bg-red-200 border-red-300'"
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold transition-all duration-200 cursor-pointer border-2 hover:shadow-sm active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                                            title="Click to toggle status">
                                                <span class="mr-1" x-text="updating ? '⏳' : (isActive ? '✓' : '✕')"></span>
                                                <span x-text="updating ? 'Updating...' : (isActive ? 'Active' : 'Inactive')"></span>
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.products.edit', $product) }}" class="text-orange-500 hover:text-orange-700">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this product?')">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Pagination -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                {{ $products->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12 bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="mx-auto h-24 w-24 text-gray-400">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No products found</h3>
                <p class="mt-2 text-gray-500">
                    @if(request()->hasAny(['search', 'category', 'type', 'status', 'featured']))
                        Try adjusting your search criteria or clear the filters.
                    @else
                        Get started by creating your first product.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'category', 'type', 'status', 'featured']))
                    <div class="mt-6">
                        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-orange-600">
                            Clear Filters
                        </a>
                    </div>
                @else
                    <div class="mt-6">
                        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-orange-600">
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Your First Product
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-admin-layout>