<x-main-layout>
    <!-- Hero Section -->
    <div class="relative bg-white">
        <div class="mx-auto max-w-7xl lg:grid lg:grid-cols-12 lg:gap-x-8 lg:px-8">
            <div class="px-6 pb-24 pt-10 sm:pb-32 lg:col-span-7 lg:px-0 lg:pb-56 lg:pt-48 xl:col-span-6">
                <div class="mx-auto max-w-2xl lg:mx-0">
                    <h1 class="mt-24 text-4xl font-bold tracking-tight text-gray-900 sm:mt-10 sm:text-6xl">{{ $weeklyTheme['title'] }}</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">{{ $weeklyTheme['description'] }}</p>
                    <div class="mt-10 flex items-center gap-x-6">
                        <a href="{{ route('products.index') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Browse Products</a>
                    </div>
                </div>
            </div>
            <div class="relative lg:col-span-5 lg:-mr-8 xl:absolute xl:inset-0 xl:left-1/2 xl:mr-0">
                <img class="aspect-[3/2] w-full bg-gray-50 object-cover lg:absolute lg:inset-0 lg:aspect-auto lg:h-full" src="https://images.unsplash.com/photo-1498758536662-35b82cd15e29?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2102&q=80" alt="">
            </div>
        </div>
    </div>

    <!-- Categories -->
    @if($categories->isNotEmpty())
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Shop by Category</h2>
            @if($categories->count() > 4)
            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                View all categories <span aria-hidden="true">&rarr;</span>
            </a>
            @endif
        </div>

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200">
                        @if($category->image_path)
                            <img src="{{ Storage::url($category->image_path) }}" alt="{{ $category->name }}" class="h-full w-full object-cover object-center group-hover:opacity-75">
                        @else
                            <div class="h-full w-full flex items-center justify-center bg-gray-100 group-hover:bg-gray-200">
                                <span class="text-2xl font-semibold text-gray-500">{{ $category->name }}</span>
                            </div>
                        @endif
                    </div>
                    <h3 class="mt-4 text-sm text-gray-700">{{ $category->name }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ $category->digital_products_count }} Products</p>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Featured Products -->
    @if($featuredProducts->isNotEmpty())
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Featured Products</h2>
            @if($featuredProducts->count() > 4)
            <a href="{{ route('products.index', ['featured' => true]) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                View all featured products <span aria-hidden="true">&rarr;</span>
            </a>
            @endif
        </div>

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @foreach($featuredProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
    @endif

    <!-- Latest Audio Messages -->
    @if($latestAudios->isNotEmpty())
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Latest Audio Messages</h2>
            @if($latestAudios->count() > 4)
            <a href="{{ route('products.index', ['type' => 'audio']) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                View all audio messages <span aria-hidden="true">&rarr;</span>
            </a>
            @endif
        </div>

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @foreach($latestAudios as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
    @endif

    <!-- Cart Drawer -->
    <div x-data="cartManager()" @keydown.window.escape="open = false">
        <!-- Cart button -->
        <button @click="open = true" type="button" class="fixed bottom-4 right-4 rounded-full bg-indigo-600 p-4 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            <span class="absolute -top-2 -right-2 h-6 w-6 rounded-full bg-red-600 text-white text-xs flex items-center justify-center" x-text="cart.reduce((sum, item) => sum + item.quantity, 0)"></span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
            </svg>
        </button>

        <!-- Cart drawer -->
        <div x-show="open" style="display: none;" class="relative z-50" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
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
                                        <button 
                                            @click="checkout"
                                            type="button"
                                            class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50"
                                            :disabled="cart.length === 0 || checkoutLoading"
                                        >
                                            <span x-text="checkoutLoading ? 'Processing...' : 'Checkout'"></span>
                                        </button>
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

    <!-- Alpine.js Cart Manager Script -->

    <script src="https://js.stripe.com/v3/"></script>

    <script>
        console.log("Stripe key:", "{{ config('services.stripe.key') }}");
        
        document.addEventListener('DOMContentLoaded', function() {
            const stripeKey = "{{ config('services.stripe.key') }}";

            console.log("Stripe key:", stripeKey); // Should print your pk_test_... key

            if (!stripeKey || stripeKey.includes('your_publishable_key')) {
                console.error('Stripe key is not configured correctly.');
                return;
            }

            if (typeof Stripe === 'undefined') {
                console.error('Stripe.js failed to load.');
                return;
            }

            try {
                // Initialize Stripe
                window.stripe = Stripe(stripeKey);
                console.log('Stripe initialized successfully.');
            } catch (error) {
                console.error('Stripe initialization failed:', error);
            }
        });
    </script>
    <script>
        function cartManager() {
            return {
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
            }
        }
    </script>
</x-main-layout>