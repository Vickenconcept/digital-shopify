<x-main-layout>
    <div class="bg-white" 
    x-data="{ 
        selectedCategories: {{ json_encode((array)request('category', [])) }},
        selectedType: {{ json_encode(request('type', '')) }},
        sortBy: {{ json_encode(request('sort', 'latest')) }},
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
        }
    }"
>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-baseline justify-between border-b border-gray-200 pb-6 pt-24">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900">Digital Products</h1>

                <div class="flex items-center">
                    <div class="relative inline-block text-left">
                        <select x-model="sortBy" @change="filterProducts()" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-8 text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                            <option value="latest" :selected="sortBy === 'latest'">Latest</option>
                            <option value="price_asc" :selected="sortBy === 'price_asc'">Price: Low to High</option>
                            <option value="price_desc" :selected="sortBy === 'price_desc'">Price: High to Low</option>
                            <option value="oldest" :selected="sortBy === 'oldest'">Oldest</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4 pb-24 pt-6">
                <!-- Filters -->
                <div class="hidden lg:block">
                    <h3 class="sr-only">Categories</h3>
                    <div class="border-b border-gray-200 py-6">
                        <h3 class="-my-3 flow-root">
                            <span class="font-medium text-gray-900">Categories</span>
                        </h3>
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
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
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
                                            class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
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
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- Cart Drawer (same as in home.blade.php) -->
    <div x-data="{ 
        open: false,
        cart: [],
        total: 0,
        checkoutLoading: false,
        init() {
            this.updateCart();
            window.addEventListener('cart-updated', () => this.updateCart());
        },
        updateCart() {
            this.cart = JSON.parse(localStorage.getItem('cart') || '[]');
            this.total = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },
        removeItem(id) {
            this.cart = this.cart.filter(item => item.id !== id);
            localStorage.setItem('cart', JSON.stringify(this.cart));
            this.updateCart();
        },
        updateQuantity(id, change) {
            const item = this.cart.find(item => item.id === id);
            if (item) {
                item.quantity = Math.max(1, item.quantity + change);
                localStorage.setItem('cart', JSON.stringify(this.cart));
                this.updateCart();
            }
        },
        async checkout() {
            if (this.cart.length === 0 || this.checkoutLoading) return;
            
            @guest
            alert('Please login to proceed with checkout');
            window.location.href = '{{ route('login') }}';
            return;
            @endguest

            this.checkoutLoading = true;
            try {
                // Create order and get payment intent
                const response = await fetch('{{ route('payment.checkout') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        cart: this.cart
                    })
                });

                const data = await response.json();
                
                if (!response.ok) {
                    throw new Error(data.error || 'Something went wrong');
                }

                // Redirect to Stripe Checkout
                if (data.checkoutUrl) {
                    window.location.href = data.checkoutUrl;
                } else {
                    throw new Error('No checkout URL received');
                }

                // Clear cart after successful payment
                localStorage.removeItem('cart');
                this.updateCart();
            } catch (error) {
                alert(error.message);
            } finally {
                this.checkoutLoading = false;
            }
        }
    }" @keydown.window.escape="open = false">
        <!-- Cart button -->
        <button @click="open = true" type="button" class="fixed bottom-4 right-4 rounded-full bg-indigo-600 p-4 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            <span class="absolute -top-2 -right-2 h-6 w-6 rounded-full bg-red-600 text-white text-xs flex items-center justify-center" x-text="cart.reduce((sum, item) => sum + item.quantity, 0)"></span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
            </svg>
        </button>

        <!-- Cart drawer -->
        <div x-show="open" style="display: none" class="relative z-50" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
            <div x-show="open" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <div x-show="open" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="pointer-events-auto w-screen max-w-md">
                            <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                                <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                                    <div class="flex items-start justify-between">
                                        <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Shopping cart</h2>
                                        <div class="ml-3 flex h-7 items-center">
                                            <button @click="open = false" type="button" class="relative -m-2 p-2 text-gray-400 hover:text-gray-500">
                                                <span class="absolute -inset-0.5"></span>
                                                <span class="sr-only">Close panel</span>
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mt-8">
                                        <div class="flow-root">
                                            <ul role="list" class="-my-6 divide-y divide-gray-200">
                                                <template x-for="item in cart" :key="item.id">
                                                    <li class="flex py-6">
                                                        <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                            <img :src="item.thumbnail" :alt="item.title" class="h-full w-full object-cover object-center">
                                                        </div>

                                                        <div class="ml-4 flex flex-1 flex-col">
                                                            <div>
                                                                <div class="flex justify-between text-base font-medium text-gray-900">
                                                                    <h3 x-text="item.title"></h3>
                                                                    <p class="ml-4" x-text="'$' + (item.price * item.quantity).toFixed(2)"></p>
                                                                </div>
                                                            </div>
                                                            <div class="flex flex-1 items-end justify-between text-sm">
                                                                <div class="flex items-center space-x-2">
                                                                    <button @click="updateQuantity(item.id, -1)" class="text-gray-500 hover:text-gray-700">-</button>
                                                                    <p class="text-gray-500" x-text="item.quantity"></p>
                                                                    <button @click="updateQuantity(item.id, 1)" class="text-gray-500 hover:text-gray-700">+</button>
                                                                </div>
                                                                <button @click="removeItem(item.id)" type="button" class="font-medium text-indigo-600 hover:text-indigo-500">Remove</button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </template>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                        <p>Subtotal</p>
                                        <p x-text="'$' + total.toFixed(2)"></p>
                                    </div>
                                    <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
                                    <div class="mt-6">
                                        @auth
                                        <button 
                                            @click="checkout"
                                            type="button"
                                            class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50"
                                            :disabled="cart.length === 0 || checkoutLoading"
                                        >
                                            <span x-text="checkoutLoading ? 'Processing...' : 'Checkout'"></span>
                                        </button>
                                        @else
                                        <a href="{{ route('login') }}" class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">Login to Checkout</a>
                                        @endauth
                                    </div>
                                    <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                                        <p>
                                            or
                                            <button @click="open = false" type="button" class="font-medium text-indigo-600 hover:text-indigo-500">
                                                Continue Shopping
                                                <span aria-hidden="true"> &rarr;</span>
                                            </button>
                                        </p>
                                    </div>
                                </div>
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