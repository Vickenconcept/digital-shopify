<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Laravel SEO Package -->
    <x-seo::meta />
    
    <!-- Default SEO for pages that don't set their own -->
    @seo([
        'title' => 'Your Journey Voices | Audiobooks & Ebooks – Stories That Travel With You',
        'description' => 'Discover Christian, children\'s, inspirational, and commuter-friendly audiobooks and ebooks. Your Journey Voices – stories that inspire and travel with you.',
        'image' => asset('images/your-journey-voices-og.jpg'),
        'site_name' => 'Your Journey Voices',
        'favicon' => asset('favicon.ico'),
    ])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body class="h-full antialiased bg-gray-50 !font-['Poppins']" x-data="{ mobileMenuOpen: false }">
    <!-- Header -->
    <header>
        <!-- Top bar -->
        <div class="bg-black text-white py-2">
            <div class="container mx-auto px-6">
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('contact') }}" class="hover:text-orange-500">Help Center</a>
                        <a href="{{ route('contact') }}" class="hover:text-orange-500">Contact Us</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ route('home') }}" class="hover:text-orange-500">My Account</a>
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
        <nav class="bg-white shadow-xl shadow-gray-100">
            <div class="container mx-auto px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                       
                        <a href="{{ url('/') }}" class="text-2xl font-bold text-orange-500">
                            Your Journey Voices
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
                            <div class="relative group">
                                <a href="{{ route('products.index') }}"
                                    class="text-base font-medium text-gray-700 hover:text-orange-500 flex items-center">
                                    Resources
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </a>
                                <div class="absolute top-full left-0 mt-1 w-64 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    <div class="py-2">
                                        <a href="{{ route('seo.christian-audiobooks') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">Christian Audiobooks</a>
                                        <a href="{{ route('seo.children-stories') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">Children's Stories</a>
                                        <a href="{{ route('seo.commuter-audiobooks') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">Commuter Audiobooks</a>
                                        <a href="{{ route('seo.inspiration-health') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">Inspiration & Health</a>
                                        <hr class="my-1">
                                        <a href="{{ route('products.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">All Resources</a>
                                    </div>
                                </div>
                            </div>
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
                    <div class="px-3 py-2">
                        <div class="text-base font-medium text-gray-700 mb-2">Resources</div>
                        <div class="ml-4 space-y-1">
                            <a href="{{ route('seo.christian-audiobooks') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-orange-500 hover:bg-gray-50 rounded-md">
                                Christian Audiobooks
                            </a>
                            <a href="{{ route('seo.children-stories') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-orange-500 hover:bg-gray-50 rounded-md">
                                Children's Stories
                            </a>
                            <a href="{{ route('seo.commuter-audiobooks') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-orange-500 hover:bg-gray-50 rounded-md">
                                Commuter Audiobooks
                            </a>
                            <a href="{{ route('seo.inspiration-health') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-orange-500 hover:bg-gray-50 rounded-md">
                                Inspiration & Health
                            </a>
                            <a href="{{ route('products.index') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-orange-500 hover:bg-gray-50 rounded-md">
                                All Resources
                            </a>
                        </div>
                    </div>
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
    <footer class="bg-gradient-to-br from-gray-900 to-black text-white mt-auto">
        <div class="container mx-auto px-6 pt-16 pb-6">
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
                        <li><a href="{{ route('products.index', ['type' => 'audio']) }}" class="text-gray-300 hover:text-orange-500 transition-colors duration-200">Audio Messages</a></li>
                        <li><a href="{{ route('products.index', ['type' => 'ebook']) }}" class="text-gray-300 hover:text-orange-500 transition-colors duration-200">E-Books</a></li>
                        <li><a href="{{ route('products.index', ['type' => 'video']) }}" class="text-gray-300 hover:text-orange-500 transition-colors duration-200">Video Content</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-gray-300 hover:text-orange-500 transition-colors duration-200">All Resources</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('blog.index') }}" class="text-gray-300 hover:text-orange-500 transition-colors duration-200">Blog</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-orange-500 transition-colors duration-200">Contact</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-orange-500 transition-colors duration-200">About</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-orange-500 transition-colors duration-200">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                   

                    <!-- Social Media Links -->
                    <div class="flex space-x-3">
                        @if(isset($siteSettings) && $siteSettings->facebook_link)
                            <a href="{{ $siteSettings->facebook_link }}" target="_blank" rel="noopener noreferrer" 
                                class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center text-gray-300 hover:text-orange-400 hover:bg-gray-700 transition-colors duration-200">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif
                        
                        @if(isset($siteSettings) && $siteSettings->twitter_link)
                            <a href="{{ $siteSettings->twitter_link }}" target="_blank" rel="noopener noreferrer" 
                                class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center text-gray-300 hover:text-orange-400 hover:bg-gray-700 transition-colors duration-200">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>
                        @endif
                        
                        @if(isset($siteSettings) && $siteSettings->instagram_link)
                            <a href="{{ $siteSettings->instagram_link }}" target="_blank" rel="noopener noreferrer" 
                                class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center text-gray-300 hover:text-orange-400 hover:bg-gray-700 transition-colors duration-200">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987s11.987-5.367 11.987-11.987C24.004 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.297-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.807.875 1.297 2.026 1.297 3.323s-.49 2.448-1.297 3.323c-.875.807-2.026 1.297-3.323 1.297zm7.83-9.281H7.721c-.49 0-.875.385-.875.875v8.958c0 .49.385.875.875.875h8.558c.49 0 .875-.385.875-.875V8.582c0-.49-.385-.875-.875-.875z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif
                        
                        @if(isset($siteSettings) && $siteSettings->youtube_link)
                            <a href="{{ $siteSettings->youtube_link }}" target="_blank" rel="noopener noreferrer" 
                                class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center text-gray-300 hover:text-orange-400 hover:bg-gray-700 transition-colors duration-200">
                                <span class="sr-only">YouTube</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif
                        
                        @if(isset($siteSettings) && $siteSettings->tiktok_link)
                            <a href="{{ $siteSettings->tiktok_link }}" target="_blank" rel="noopener noreferrer" 
                                class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center text-gray-300 hover:text-orange-400 hover:bg-gray-700 transition-colors duration-200">
                                <span class="sr-only">TikTok</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-gray-800 pt-6 mt-6">
                <div class="">
                    <div class="text-center">
                        <p class="text-gray-300 text-sm">
                            © {{ date('Y') }} Your Journey Voices. All rights reserved.
                        </p>
                        <p class="text-gray-400 text-xs mt-1">
                            Stories That Travel With You
                        </p>
                    </div>
                   
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts

    <!-- Cart Drawer -->
    <div x-data="cartManager()" @keydown.window.escape="open = false">
        <!-- Cart button -->
        <button @click="open = true" type="button"
            class="fixed z-50 bottom-4 right-4 rounded-full bg-orange-500 p-4 text-white shadow-sm hover:bg-orange-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-500">
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
                                        <div>
                                            <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Shopping Cart</h2>
                                            <p class="mt-1 text-sm text-gray-500" x-show="cart.length > 0" x-text="cart.length + ' item' + (cart.length !== 1 ? 's' : '') + ' in your cart'"></p>
                                        </div>
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
                                        <!-- Empty Cart State -->
                                        <div x-show="cart.length === 0" class="text-center py-12">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">Your cart is empty</h3>
                                            <p class="mt-1 text-sm text-gray-500">Start adding some items to your cart.</p>
                                            <div class="mt-6">
                                                <button @click="open = false" type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                                    Continue Shopping
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Cart Items -->
                                        <div x-show="cart.length > 0" class="flow-root">
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
                                                                <div class="flex justify-between text-base font-medium text-gray-900">
                                                                    <h3 x-text="item.title"></h3>
                                                                    <p class="ml-4 text-sm text-gray-500" x-text="'$' + item.price.toFixed(2) + ' each'"></p>
                                                                </div>
                                                            </div>
                                                            <div class="flex flex-1 items-end justify-between text-sm">
                                                                <div class="flex items-center space-x-3">
                                                                    <!-- Quantity Controls -->
                                                                    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                                                        <!-- Minus Button -->
                                                                        <button @click="updateQuantity(item.id, -1)"
                                                                            class="flex items-center justify-center w-8 h-8 bg-gray-50 hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-inset"
                                                                            :disabled="item.quantity <= 1"
                                                                            :class="item.quantity <= 1 ? 'opacity-50 cursor-not-allowed' : ''">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                                            </svg>
                                                                        </button>
                                                                        
                                                                        <!-- Quantity Display -->
                                                                        <div class="flex items-center justify-center w-12 h-8 bg-white border-x border-gray-300">
                                                                            <span class="text-sm font-medium text-gray-900" x-text="item.quantity"></span>
                                                                        </div>
                                                                        
                                                                        <!-- Plus Button -->
                                                                        <button @click="updateQuantity(item.id, 1)"
                                                                            class="flex items-center justify-center w-8 h-8 bg-gray-50 hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-inset">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                    
                                                                    <!-- Item Total -->
                                                                    <div class="text-sm font-medium text-gray-900">
                                                                        <span x-text="'$' + (item.price * item.quantity).toFixed(2)"></span>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- Remove Button -->
                                                                <button @click="removeItem(item.id)" type="button"
                                                                    class="flex items-center space-x-1 px-3 py-1.5 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                    </svg>
                                                                    <span>Remove</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </template>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Checkout Section (only show when cart has items) -->
                                <div x-show="cart.length > 0" class="border-t border-gray-200 px-4 py-6 sm:px-6">
                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                        <p>Subtotal</p>
                                        <p x-text="'$' + total.toFixed(2)"></p>
                                    </div>
                                    <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
                                    
                                    <div class="mt-6">
                                        <button @click="checkout" type="button"
                                            class="flex w-full items-center justify-center rounded-md border border-transparent bg-orange-500 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 disabled:opacity-50 transition-colors duration-200"
                                            :disabled="cart.length === 0 || checkoutLoading">
                                            <svg x-show="!checkoutLoading" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                            <svg x-show="checkoutLoading" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span x-text="checkoutLoading ? 'Processing...' : 'Proceed to Checkout'"></span>
                                        </button>
                                    </div>
                                    
                                    <div class="mt-4 flex justify-center text-center text-sm text-gray-500">
                                        <p>
                                            or
                                            <button @click="open = false" type="button"
                                                class="font-medium text-orange-500 hover:text-orange-600 transition-colors duration-200">
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

    <!-- Simple Theme Rotator -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dayMessages = @json($dayMessages ?? []);
            const currentDay = '{{ $currentDay ?? 'monday' }}';
            const themeTitle = '{{ isset($weeklyTheme) && is_array($weeklyTheme) ? ($weeklyTheme['title'] ?? '') : '' }}';
            
            console.log('Simple Theme Rotator initialized');
            console.log('Current day:', currentDay);
            console.log('Day message:', dayMessages[currentDay]);
            
            // Check if we have a message for the current day
            if (dayMessages[currentDay] && dayMessages[currentDay].trim() !== '') {
                const messages = [themeTitle, dayMessages[currentDay]];
                let currentIndex = 0;
                
                console.log('Starting rotation with messages:', messages);
                
                // Update the title immediately
                const titleElement = document.getElementById('rotating-title');
                if (titleElement) {
                    titleElement.textContent = messages[currentIndex];
                }
                
                // Rotate every 10 seconds
                setInterval(() => {
                    currentIndex = (currentIndex + 1) % messages.length;
                    if (titleElement) {
                        titleElement.textContent = messages[currentIndex];
                        console.log('Rotated to:', messages[currentIndex]);
                    }
                }, 10000);
            } else {
                console.log('No message for', currentDay, '- showing static title');
            }
        });
    </script>

    <!-- Hero Image Rotator -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const heroImages = [];
            
            // Collect available hero images
            for (let i = 1; i <= 3; i++) {
                const img = document.getElementById(`hero-image-${i}`);
                if (img && img.src) {
                    heroImages.push(img);
                }
            }
            
            console.log('Hero Image Rotator initialized with', heroImages.length, 'images');
            
            // Only rotate if we have more than one image
            if (heroImages.length > 1) {
                let currentIndex = 0;
                
                // Rotate every 10 seconds
                setInterval(() => {
                    // Hide current image
                    heroImages[currentIndex].style.display = 'none';
                    
                    // Move to next image
                    currentIndex = (currentIndex + 1) % heroImages.length;
                    
                    // Show next image
                    heroImages[currentIndex].style.display = 'block';
                    
                    console.log('Rotated to hero image', currentIndex + 1);
                }, 10000);
            } else if (heroImages.length === 1) {
                console.log('Only one hero image available, no rotation needed');
            } else {
                console.log('No hero images available, using default image');
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
