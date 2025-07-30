<x-main-layout>
    <div class="bg-white" x-data="{ 
        inWishlist: false,
        init() {
            // Check if product is in wishlist
            const wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
            this.inWishlist = wishlist.includes({{ $product->id }});
        },
        toggleWishlist() {
            let wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
            if (this.inWishlist) {
                wishlist = wishlist.filter(id => id !== {{ $product->id }});
            } else {
                wishlist.push({{ $product->id }});
            }
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            this.inWishlist = !this.inWishlist;
            
            // Dispatch event for wishlist update
            window.dispatchEvent(new CustomEvent('wishlist-updated'));
        },
        addToCart() {
            let cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const existingItem = cart.find(item => item.id === {{ $product->id }});
            
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    id: {{ $product->id }},
                    title: '{{ $product->title }}',
                    price: {{ $product->price }},
                    thumbnail: '{{ $product->thumbnail_path }}',
                    quantity: 1
                });
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            
            // Dispatch event for cart update
            window.dispatchEvent(new CustomEvent('cart-updated'));
        }
    }">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:grid lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
            <!-- Product details -->
            <div class="lg:max-w-lg lg:self-end">
                <nav aria-label="Breadcrumb">
                    <ol role="list" class="flex items-center space-x-2">
                        <li>
                            <div class="flex items-center text-sm">
                                <a href="{{ route('products.index') }}" class="font-medium text-gray-500 hover:text-gray-900">Products</a>
                                <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="ml-2 h-5 w-5 flex-shrink-0 text-gray-300">
                                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                </svg>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center text-sm">
                                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="font-medium text-gray-500 hover:text-gray-900">{{ $product->category->name }}</a>
                            </div>
                        </li>
                    </ol>
                </nav>

                <div class="mt-4">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ $product->title }}</h1>
                </div>

                <section aria-labelledby="information-heading" class="mt-4">
                    <h2 id="information-heading" class="sr-only">Product information</h2>

                    <div class="flex items-center">
                        @if($product->is_free)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Free Resource
                            </span>
                        @else
                            <p class="text-lg text-gray-900 sm:text-xl">${{ number_format($product->price, 2) }}</p>
                        @endif

                        <div class="ml-4 border-l border-gray-300 pl-4">
                            <h2 class="sr-only">Type</h2>
                            <div class="flex items-center">
                                <p class="text-sm text-gray-500">{{ ucfirst($product->file_type) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 space-y-6">
                        <p class="text-base text-gray-500">{{ $product->description }}</p>
                    </div>

                    <div class="mt-6 flex items-center">
                        <button @click="toggleWishlist" type="button" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Add to favorites</span>
                            <svg x-show="!inWishlist" class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <svg x-show="inWishlist" class="h-8 w-8 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L12 8.343l3.172-3.171a4 4 0 115.656 5.656L12 19.657l-8.828-8.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </section>
            </div>

            <!-- Product image -->
            <div class="mt-10 lg:col-start-2 lg:row-span-2 lg:mt-0 lg:self-center">
                <div class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg">
                    <img src="{{ $product->thumbnail_path }}" alt="{{ $product->title }}" class="h-full w-full object-cover object-center">
                </div>
            </div>

            <!-- Add to cart -->
            <div class="mt-10 lg:col-start-1 lg:row-start-2 lg:max-w-lg lg:self-start">
                <div class="mt-10">
                    <button @click="addToCart" type="button" class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Add to Cart</button>
                </div>

                @if($product->preview_path)
                    <div class="mt-6">
                        <a href="{{ $product->preview_path }}" class="text-base font-medium text-indigo-600 hover:text-indigo-500">Preview Sample</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Related products -->
        @if($relatedProducts->isNotEmpty())
            <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
                <h2 class="text-xl font-bold text-gray-900">Related Products</h2>

                <div class="mt-8 grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                    @foreach($relatedProducts as $related)
                        <x-product-card :product="$related" />
                    @endforeach
                </div>
            </div>
        @endif
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
        <div x-show="open" class="relative z-50" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
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
</x-main-layout>