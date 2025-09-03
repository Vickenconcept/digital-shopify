<x-main-layout>
    <div class="bg-white" 
    x-data="{ 
        selectedCategories: {{ json_encode((array)request('category', [])) }},
        selectedType: {{ json_encode(request('type', '')) }},
        sortBy: {{ json_encode(request('sort', 'latest')) }},
        filterDrawerOpen: false,
        filterProducts() {
            const params = new URLSearchParams();
            
            if (this.selectedCategories.length > 0) {
                this.selectedCategories.forEach(category => {
                    params.append('category[]', category);
                });
            }
            
            if (this.selectedType) {
                params.append('type', this.selectedType);
            }
            
            if (this.sortBy) {
                params.append('sort', this.sortBy);
            }
            
            window.location.href = `${window.location.pathname}?${params.toString()}`;
        },
        clearFilters() {
            this.selectedCategories = [];
            this.selectedType = '';
            this.sortBy = 'latest';
            this.filterProducts();
        }
    }"
>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-baseline justify-between border-b border-gray-200 pb-6 pt-24">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900">Digital Products</h1>

                <div class="flex items-center space-x-4">
                    <!-- Mobile Filter Button -->
                    <button 
                        @click="filterDrawerOpen = true"
                        class="lg:hidden inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                    >
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
                        </svg>
                        Filters
                        <span x-show="selectedCategories.length > 0 || selectedType" class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                            <span x-text="(selectedCategories.length + (selectedType ? 1 : 0))"></span>
                        </span>
                    </button>

                    <!-- Sort Dropdown -->
                    <div class="relative inline-block text-left">
                        <select x-model="sortBy" @change="filterProducts()" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-8 text-gray-500 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm">
                            <option value="latest" :selected="sortBy === 'latest'">Latest</option>
                            <option value="price_asc" :selected="sortBy === 'price_asc'">Price: Low to High</option>
                            <option value="price_desc" :selected="sortBy === 'price_desc'">Price: High to Low</option>
                            <option value="oldest" :selected="sortBy === 'oldest'">Oldest</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4 pb-24 pt-6">
                <!-- Desktop Filters -->
                <div class="hidden lg:block">
                    <h3 class="sr-only">Categories</h3>
                    <div class="border-b border-gray-200 py-6">
                        <div class="flex items-center justify-between">
                            <h3 class="-my-3 flow-root">
                                <span class="font-medium text-gray-900">Categories</span>
                            </h3>
                            <button 
                                @click="clearFilters()" 
                                x-show="selectedCategories.length > 0 || selectedType"
                                class="text-sm text-orange-600 hover:text-orange-500"
                            >
                                Clear
                            </button>
                        </div>
                        <div class="pt-6" id="filter-section-0">
                            <div class="space-y-4">
                                @foreach($categories as $category)
                                    <div class="flex items-center">
                                        <input 
                                            id="category-{{ $category->id }}" 
                                            value="{{ $category->slug }}" 
                                            type="checkbox" 
                                            x-model="selectedCategories"
                                            @change="filterProducts()"
                                            :checked="selectedCategories.includes('{{ $category->slug }}')"
                                            class="h-4 w-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500"
                                        >
                                        <label for="category-{{ $category->id }}" class="ml-3 text-sm text-gray-600">{{ $category->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="border-b border-gray-200 py-6">
                        <h3 class="-my-3 flow-root">
                            <span class="font-medium text-gray-900">Type</span>
                        </h3>
                        <div class="pt-6">
                            <div class="space-y-4">
                                @foreach(['audio', 'video', 'ebook'] as $type)
                                    <div class="flex items-center">
                                        <input 
                                            id="type-{{ $type }}" 
                                            value="{{ $type }}" 
                                            type="radio" 
                                            x-model="selectedType"
                                            @change="filterProducts()"
                                            :checked="selectedType === '{{ $type }}'"
                                            class="h-4 w-4 border-gray-300 text-orange-600 focus:ring-orange-500"
                                        >
                                        <label for="type-{{ $type }}" class="ml-3 text-sm text-gray-600">{{ ucfirst($type) }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product grid -->
                <div class="lg:col-span-3">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                <x-custom-pagination :paginator="$products" />
            </div>
        </div>

        <!-- Mobile Filter Drawer -->
        <div x-show="filterDrawerOpen" 
             x-transition:enter="transition ease-in-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in-out duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-hidden lg:hidden"
             style="display: none;">
            
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="filterDrawerOpen = false"></div>
            
            <!-- Drawer -->
            <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div x-show="filterDrawerOpen"
                     x-transition:enter="transform transition ease-in-out duration-300"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-300"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     class="w-screen max-w-md">
                    
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                        <!-- Header -->
                        <div class="flex items-center justify-between px-4 py-6 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                            <button @click="filterDrawerOpen = false" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Filter Content -->
                        <div class="flex-1 overflow-y-auto px-4 py-6">
                            <!-- Categories -->
                            <div class="border-b border-gray-200 pb-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-base font-medium text-gray-900">Categories</h3>
                                    <button 
                                        @click="selectedCategories = []" 
                                        x-show="selectedCategories.length > 0"
                                        class="text-sm text-orange-600 hover:text-orange-500"
                                    >
                                        Clear
                                    </button>
                                </div>
                                <div class="space-y-4">
                                    @foreach($categories as $category)
                                        <div class="flex items-center">
                                            <input 
                                                id="mobile-category-{{ $category->id }}" 
                                                value="{{ $category->slug }}" 
                                                type="checkbox" 
                                                x-model="selectedCategories"
                                                :checked="selectedCategories.includes('{{ $category->slug }}')"
                                                class="h-4 w-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500"
                                            >
                                            <label for="mobile-category-{{ $category->id }}" class="ml-3 text-sm text-gray-600">{{ $category->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Type -->
                            <div class="border-b border-gray-200 py-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-base font-medium text-gray-900">Type</h3>
                                    <button 
                                        @click="selectedType = ''" 
                                        x-show="selectedType"
                                        class="text-sm text-orange-600 hover:text-orange-500"
                                    >
                                        Clear
                                    </button>
                                </div>
                                <div class="space-y-4">
                                    @foreach(['audio', 'video', 'ebook'] as $type)
                                        <div class="flex items-center">
                                            <input 
                                                id="mobile-type-{{ $type }}" 
                                                value="{{ $type }}" 
                                                type="radio" 
                                                x-model="selectedType"
                                                :checked="selectedType === '{{ $type }}'"
                                                class="h-4 w-4 border-gray-300 text-orange-600 focus:ring-orange-500"
                                            >
                                            <label for="mobile-type-{{ $type }}" class="ml-3 text-sm text-gray-600">{{ ucfirst($type) }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="border-t border-gray-200 px-4 py-6">
                            <div class="flex space-x-3">
                                <button 
                                    @click="clearFilters(); filterDrawerOpen = false" 
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                                >
                                    Clear All
                                </button>
                                <button 
                                    @click="filterProducts(); filterDrawerOpen = false" 
                                    class="flex-1 px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                                >
                                    Apply Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Handle filter form submission
        document.getElementById('sort').addEventListener('change', function() {
            this.form.submit();
        });

        document.querySelectorAll('input[name="category[]"], input[name="type"]').forEach(input => {
            input.addEventListener('change', function() {
                this.form.submit();
            });
        });
    </script>
    @endpush
</x-main-layout>