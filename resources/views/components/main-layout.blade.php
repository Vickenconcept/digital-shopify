<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pastor Charlene Boyd') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body class="h-full font-sans antialiased bg-white" x-data="{ mobileMenuOpen: false }">
    <!-- Header -->
    <header>
        <!-- Top bar -->
        <div class="bg-black text-white py-2">
            <div class="container mx-auto px-6">
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center space-x-4">
                        <a href="#" class="hover:text-orange-500">Help Center</a>
                        <a href="#" class="hover:text-orange-500">Contact Us</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="hover:text-orange-500">My Account</a>
                            <form method="POST" action="{{ route('auth.logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="hover:text-orange-500">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="hover:text-orange-500">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="hover:text-orange-500">Register</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Main header -->
        <nav class="bg-white shadow">
            <div class="container mx-auto px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                       
                        <a href="{{ url('/') }}" class="text-2xl font-bold text-orange-500">
                            Pastor Charlene Boyd
                        </a>

                        <div class="hidden md:flex items-center ml-10 space-x-8">
                            <a href="{{ route('about') }}"
                                class="text-base font-medium text-gray-700 hover:text-orange-500">
                                About
                            </a>
                            <a href="{{ route('blog.index') }}"
                                class="text-base font-medium text-gray-700 hover:text-orange-500">
                                Blog
                            </a>
                            <a href="{{ route('products.index') }}"
                                class="text-base font-medium text-gray-700 hover:text-orange-500">
                                Resources
                            </a>
                            <a href="{{ route('contact') }}"
                                class="text-base font-medium text-gray-700 hover:text-orange-500">
                                Contact
                            </a>
                        </div>

                        <!-- Mobile menu button -->
                        <div class="md:hidden">
                            <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 hover:text-orange-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Search bar -->
                    <div class="hidden md:flex items-center flex-1 max-w-lg ml-8" x-data="searchManager()">
                        <div class="relative w-full">
                            <input type="text" 
                                placeholder="Search products..." 
                                x-model="query"
                                @input.debounce.300ms="search()"
                                @focus="showDropdown = true; if (products.length === 0) setTimeout(() => search(), 100)"
                                @blur="setTimeout(() => showDropdown = false, 200)"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                            <button @click="showDropdown = true; search()" class="absolute right-3 top-1/2 -translate-y-1/2">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                            
                            <!-- Search Dropdown -->
                            <div x-show="showDropdown && (products.length > 0 || loading)"  style="display: none;"  
                                 @click.stop
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-95"
                                 class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-96 overflow-y-auto">
                                
                                <!-- Loading State -->
                                <div x-show="loading" class="p-4 text-center text-gray-500">
                                    <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <p class="mt-2">Searching...</p>
                                </div>
                                
                                <!-- Results -->
                                <template x-for="product in products" :key="product.id">
                                    <div class="p-3 hover:bg-gray-50 border-b border-gray-100 last:border-b-0">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <img :src="product.thumbnail" :alt="product.title" 
                                                     class="h-12 w-12 object-cover rounded-lg">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-medium text-gray-900 truncate" x-text="product.title"></h4>
                                                <p class="text-xs text-gray-500" x-text="product.author"></p>
                                                <p class="text-xs text-gray-400" x-text="product.category"></p>
                                            </div>
                                            <div class="flex-shrink-0 flex items-center space-x-2">
                                                <span class="text-sm font-medium text-gray-900" x-text="product.is_free ? 'Free' : '$' + product.price"></span>
                                                <div class="flex space-x-1">
                                                    <button @click="viewProduct(product.slug)" 
                                                            class="text-xs bg-orange-500 text-white px-2 py-1 rounded hover:bg-orange-600">
                                                        View
                                                    </button>
                                                    <button @click="addToCart(product)" 
                                                            class="text-xs bg-black text-white px-2 py-1 rounded hover:bg-gray-800">
                                                        Add
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                
                                <!-- No Results -->
                                <div x-show="!loading && products.length === 0 && query.length > 0" 
                                     class="p-4 text-center text-gray-500">
                                    <p>No products found</p>
                                </div>
                                
                                <!-- View All Results -->
                                <div x-show="products.length > 0" class="p-3 bg-gray-50 border-t border-gray-200">
                                    <a href="#" @click.prevent="viewAllResults()" 
                                       class="text-sm text-orange-500 hover:text-orange-600 font-medium">
                                        View all results
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-1"
             class="md:hidden bg-white border-t border-gray-200">
            <div class="px-4 py-3">
                <!-- Mobile Search -->
                <div class="relative mb-4" x-data="searchManager()">
                    <input type="text" 
                        placeholder="Search products..." 
                        x-model="query"
                        @input.debounce.300ms="search()"
                        @focus="showDropdown = true; if (products.length === 0) setTimeout(() => search(), 100)"
                        @blur="setTimeout(() => showDropdown = false, 200)"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500">
                    
                    <!-- Mobile Search Dropdown -->
                    <div x-show="showDropdown && (products.length > 0 || loading)" 
                         @click.stop
                         class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-64 overflow-y-auto">
                        
                        <!-- Loading State -->
                        <div x-show="loading" class="p-4 text-center text-gray-500">
                            <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="mt-2">Searching...</p>
                        </div>
                        
                        <!-- Results -->
                        <template x-for="product in products" :key="product.id">
                            <div class="p-3 hover:bg-gray-50 border-b border-gray-100 last:border-b-0">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <img :src="product.thumbnail" :alt="product.title" 
                                             class="h-12 w-12 object-cover rounded-lg">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium text-gray-900 truncate" x-text="product.title"></h4>
                                        <p class="text-xs text-gray-500" x-text="product.author"></p>
                                        <p class="text-xs text-gray-400" x-text="product.category"></p>
                                    </div>
                                    <div class="flex-shrink-0 flex items-center space-x-2">
                                        <span class="text-sm font-medium text-gray-900" x-text="product.is_free ? 'Free' : '$' + product.price"></span>
                                        <div class="flex space-x-1">
                                            <button @click="viewProduct(product.slug)" 
                                                    class="text-xs bg-orange-500 text-white px-2 py-1 rounded hover:bg-orange-600">
                                                View
                                            </button>
                                            <button @click="addToCart(product)" 
                                                    class="text-xs bg-black text-white px-2 py-1 rounded hover:bg-gray-800">
                                                Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        
                        <!-- No Results -->
                        <div x-show="!loading && products.length === 0 && query.length > 0" 
                             class="p-4 text-center text-gray-500">
                            <p>No products found</p>
                        </div>
                        
                        <!-- View All Results -->
                        <div x-show="products.length > 0" class="p-3 bg-gray-50 border-t border-gray-200">
                            <a href="#" @click.prevent="viewAllResults()" 
                               class="text-sm text-orange-500 hover:text-orange-600 font-medium">
                                View all results
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Mobile Navigation Links -->
                <div class="space-y-2">
                    <a href="{{ route('about') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-orange-500 hover:bg-gray-50 rounded-md">
                        About
                    </a>
                    <a href="{{ route('blog.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-orange-500 hover:bg-gray-50 rounded-md">
                        Blog
                    </a>
                    <a href="{{ route('products.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-orange-500 hover:bg-gray-50 rounded-md">
                        Resources
                    </a>
                    <a href="{{ route('contact') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-orange-500 hover:bg-gray-50 rounded-md">
                        Contact
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto">
        @if (isset($header))
            <div class="mb-8">
                {{ $header }}
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-black text-white mt-auto">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">About Us</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-orange-500">Our Story</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-orange-500">Mission & Vision</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-orange-500">Leadership</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-orange-500">Audio Messages</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-orange-500">E-Books</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-orange-500">Video Content</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Help</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-orange-500">FAQs</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-orange-500">Contact Support</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-orange-500">Terms of Service</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Connect With Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-orange-500">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-orange-500">
                            <span class="sr-only">YouTube</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                    <p class="mt-4 text-sm text-gray-300">
                        © {{ date('Y') }} Pastor Charlene Boyd.<br>All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts

    <!-- Cart Drawer -->
    <div x-data="cartManager()" @keydown.window.escape="open = false">
        <!-- Cart button -->
        <button @click="open = true" type="button"
            class="fixed z-50 bottom-4 right-4 rounded-full bg-orange-500 p-4 text-white shadow-sm hover:bg-orange-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-500">
            <span
                class="absolute -top-2 -right-2 h-6 w-6 rounded-full bg-black text-white text-xs flex items-center justify-center"
                x-text="cart.reduce((sum, item) => sum + item.quantity, 0)"></span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
            </svg>
        </button>

        <!-- Cart drawer -->
        <div x-show="open" style="display: none;" class="relative z-50" aria-labelledby="slide-over-title"
            role="dialog" aria-modal="true">
            <div x-show="open" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <div x-show="open"
                            x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                            x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                            class="pointer-events-auto w-screen max-w-md">
                            <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                                <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                                    <div class="flex items-start justify-between">
                                        <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Shopping
                                            cart</h2>
                                        <div class="ml-3 flex h-7 items-center">
                                            <button @click="open = false" type="button"
                                                class="relative -m-2 p-2 text-gray-400 hover:text-gray-500">
                                                <span class="absolute -inset-0.5"></span>
                                                <span class="sr-only">Close panel</span>
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mt-8">
                                        <div class="flow-root">
                                            <ul role="list" class="-my-6 divide-y divide-gray-200">
                                                <template x-for="item in cart" :key="item.id">
                                                    <li class="flex py-6">
                                                        <div
                                                            class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                            <img :src="item.thumbnail" :alt="item.title"
                                                                class="h-full w-full object-cover object-center">
                                                        </div>

                                                        <div class="ml-4 flex flex-1 flex-col">
                                                            <div>
                                                                <div
                                                                    class="flex justify-between text-base font-medium text-gray-900">
                                                                    <h3 x-text="item.title"></h3>
                                                                    <p class="ml-4"
                                                                        x-text="'$' + (item.price * item.quantity).toFixed(2)">
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="flex flex-1 items-end justify-between text-sm">
                                                                <div class="flex items-center space-x-2">
                                                                    <button @click="updateQuantity(item.id, -1)"
                                                                        class="text-gray-500 hover:text-gray-700">-</button>
                                                                    <p class="text-gray-500" x-text="item.quantity">
                                                                    </p>
                                                                    <button @click="updateQuantity(item.id, 1)"
                                                                        class="text-gray-500 hover:text-gray-700">+</button>
                                                                </div>
                                                                <button @click="removeItem(item.id)" type="button"
                                                                    class="font-medium text-orange-500 hover:text-orange-600">Remove</button>
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
                                    <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.
                                    </p>
                                    <div class="mt-6">
                                        <button @click="checkout" type="button"
                                            class="flex w-full items-center justify-center rounded-md border border-transparent bg-orange-500 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 disabled:opacity-50"
                                            :disabled="cart.length === 0 || checkoutLoading">
                                            <span x-text="checkoutLoading ? 'Processing...' : 'Checkout'"></span>
                                        </button>
                                    </div>
                                    <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                                        <p>
                                            or
                                            <button @click="open = false" type="button"
                                                class="font-medium text-orange-500 hover:text-orange-600">
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

    <!-- Stripe Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stripeKey = "{{ config('services.stripe.key') }}";

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
            } catch (error) {
                console.error('Stripe initialization failed:', error);
            }
        });
    </script>

    <!-- Search Manager -->
    <script>
        function searchManager() {
            return {
                query: '',
                products: [],
                loading: false,
                searching: false,
                showDropdown: false,

                async search() {
                    // Prevent multiple simultaneous searches
                    if (this.searching) return;
                    
                    // Don't search if query is empty and we already have featured products
                    if (this.query.length === 0 && this.products.length > 0 && !this.loading) return;
                    
                    this.searching = true;
                    this.loading = true;
                    
                    try {
                        const url = `{{ route('products.search') }}?q=${encodeURIComponent(this.query)}&limit=8`;
                        console.log('Searching:', url);
                        const response = await fetch(url);
                        
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        
                        const data = await response.json();
                        this.products = data.products;
                        console.log('Search results:', this.products);
                        console.log('Dropdown should be visible:', this.showDropdown && (this.products.length > 0 || this.loading));
                    } catch (error) {
                        console.error('Search error:', error);
                        this.products = [];
                    } finally {
                        this.loading = false;
                        this.searching = false;
                    }
                },

                viewProduct(slug) {
                    window.location.href = `{{ url('/products') }}/${slug}`;
                },

                addToCart(product) {
                    // Get existing cart
                    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
                    
                    // Check if product already exists in cart
                    const existingItem = cart.find(item => item.id === product.id);
                    
                    if (existingItem) {
                        existingItem.quantity += 1;
                    } else {
                        cart.push({
                            id: product.id,
                            title: product.title,
                            price: parseFloat(product.price),
                            thumbnail: product.thumbnail,
                            quantity: 1
                        });
                    }
                    
                    // Save to localStorage
                    localStorage.setItem('cart', JSON.stringify(cart));
                    
                    // Dispatch event to update cart
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                    
                    // Show success message
                    if (window.Toastify) {
                        Toastify({
                            text: `${product.title} added to cart!`,
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#f97316",
                            stopOnFocus: true
                        }).showToast();
                    }
                    
                    this.showDropdown = false;
                },

                viewAllResults() {
                    window.location.href = `{{ route('products.index') }}?search=${encodeURIComponent(this.query)}`;
                }
            }
        }
    </script>

    <!-- Cart Manager -->
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
</body>

</html>
