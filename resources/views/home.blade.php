<x-main-layout>
    @seo([
        'title' => 'Your Journey Voices | Audiobooks & Ebooks – Stories That Travel With You',
        'description' => 'Discover Christian, children\'s, inspirational, and commuter-friendly audiobooks and ebooks. Your Journey Voices – stories that inspire and travel with you.',
        'keywords' => 'journey voices audiobooks, inspirational audiobooks online, ebooks and audiobooks collection, stories that travel with you, Christian audiobooks, children audiobooks, commuter audiobooks',
        'image' => asset('images/your-journey-voices-og.jpg'),
        'site_name' => 'Your Journey Voices',
    ])
    <!-- Hero Section -->
    <div class="relative mt-5 mb-10">
            <div class="mx-auto w-full lg:grid lg:grid-cols-2 overflow-hidden rounded-2xl border border-gray-200 lg:w-[90%] shadow-2xl shadow-gray-100">
                <div class="pl-16 pr-10 pb-24 pt-20 sm:pb-32 lg:col-span-1 bg-black text-white">
                    <div class="mx-auto max-w-2xl lg:mx-0">
                        <!-- Dynamic Theme Title with Rotation -->
                        <div class="mt-24 sm:mt-10">
                            <h1 id="rotating-title" class="text-3xl font-semibold tracking-tight text-gray-50 sm:text-6xl">
                                {{ $weeklyTheme['title'] ?? 'Your Journey Voices – Stories That Travel With You' }}
                            </h1>
                        </div>
                        
                        <p class="mt-6 text-lg leading-8 text-gray-100">{{ $weeklyTheme['description'] ?? 'Discover inspiring Christian audiobooks, children\'s bedtime stories, and motivational content perfect for commuters. Your Journey Voices brings you stories that inspire, educate, and travel with you wherever life takes you.' }}</p>
                        <div class="mt-10 flex items-center gap-x-6">
                            <a href="{{ route('products.index') }}" class="rounded-md bg-orange-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-orange-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-500">
                                {{ $siteSettings->cta_button_text ?? 'Browse Products' }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="relative lg:col-span-1">
                    <div id="hero-image-container" class="aspect-[3/2] w-full bg-gray-50 lg:absolute lg:inset-0 lg:aspect-auto lg:h-full overflow-hidden">
                        @if($siteSettings->hero_image_1 || $siteSettings->hero_image_2 || $siteSettings->hero_image_3)
                            @if($siteSettings->hero_image_1)
                                <img id="hero-image-1" class="w-full h-full object-cover transition-opacity duration-1000" src="{{ $siteSettings->hero_image_1 }}" alt="Hero Image 1" style="display: block;">
                            @endif
                            @if($siteSettings->hero_image_2)
                                <img id="hero-image-2" class="w-full h-full object-cover transition-opacity duration-1000" src="{{ $siteSettings->hero_image_2 }}" alt="Hero Image 2" style="display: none;">
                            @endif
                            @if($siteSettings->hero_image_3)
                                <img id="hero-image-3" class="w-full h-full object-cover transition-opacity duration-1000" src="{{ $siteSettings->hero_image_3 }}" alt="Hero Image 3" style="display: none;">
                            @endif
                        @else
                            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1498758536662-35b82cd15e29?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2102&q=80" alt="Default Hero Image">
                        @endif
                    </div>
                </div>
            </div>
    </div>

    <!-- Resource Categories Banner -->
    <section class="py-16 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Discover Your Perfect Stories
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Explore our curated collections designed for every moment of your journey. From spiritual growth to family time, 
                    we have the perfect stories waiting for you.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Christian Audiobooks Card -->
                <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-600 to-blue-800 text-white shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/90 to-blue-800/90"></div>
                    <div class="relative p-8 h-full flex flex-col">
                        <div class="mb-6">
                            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-4 group-hover:bg-white/30 transition-colors">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Christian Audiobooks</h3>
                            <p class="text-blue-100 text-sm leading-relaxed">
                                Strengthen your faith with inspiring biblical stories, devotionals, and Christian teachings perfect for daily spiritual growth.
                            </p>
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('seo.christian-audiobooks') }}" class="inline-flex items-center text-white font-semibold hover:text-blue-200 transition-colors">
                                Explore Collection
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Children's Stories Card -->
                <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-pink-500 to-purple-600 text-white shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-500/90 to-purple-600/90"></div>
                    <div class="relative p-8 h-full flex flex-col">
                        <div class="mb-6">
                            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-4 group-hover:bg-white/30 transition-colors">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Children's Stories</h3>
                            <p class="text-pink-100 text-sm leading-relaxed">
                                Magical bedtime stories, Bible tales, and family-friendly adventures that spark imagination and create precious memories.
                            </p>
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('seo.children-stories') }}" class="inline-flex items-center text-white font-semibold hover:text-pink-200 transition-colors">
                                Explore Collection
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Commuter Audiobooks Card -->
                <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-green-500 to-teal-600 text-white shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500/90 to-teal-600/90"></div>
                    <div class="relative p-8 h-full flex flex-col">
                        <div class="mb-6">
                            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-4 group-hover:bg-white/30 transition-colors">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Commuter Audiobooks</h3>
                            <p class="text-green-100 text-sm leading-relaxed">
                                Transform your daily commute with uplifting stories, motivational content, and inspiring tales perfect for busy lifestyles.
                            </p>
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('seo.commuter-audiobooks') }}" class="inline-flex items-center text-white font-semibold hover:text-green-200 transition-colors">
                                Explore Collection
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Inspiration & Health Card -->
                <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-purple-600 to-indigo-700 text-white shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-600/90 to-indigo-700/90"></div>
                    <div class="relative p-8 h-full flex flex-col">
                        <div class="mb-6">
                            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-4 group-hover:bg-white/30 transition-colors">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Inspiration & Health</h3>
                            <p class="text-purple-100 text-sm leading-relaxed">
                                Boost your mental wellness with motivational stories, personal development content, and healing narratives for mind and soul.
                            </p>
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('seo.inspiration-health') }}" class="inline-flex items-center text-white font-semibold hover:text-purple-200 transition-colors">
                                Explore Collection
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="text-center mt-12">
                <a href="{{ route('products.index') }}" class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Browse All Resources
                </a>
            </div>
        </div>
    </section>

    <!-- Categories -->
    @if($categories->isNotEmpty())
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Go by Category</h2>
            @if($categories->count() > 4)
            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                View all categories <span aria-hidden="true">&rarr;</span>
            </a>
            @endif
        </div>

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group shadow-2xl shadow-blue-100">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200">
                        @if($category->image_path)
                            <img src="{{ $category->image_path }}" alt="{{ $category->name }}" class="h-full w-full object-cover object-center group-hover:opacity-75">
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
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Featured Contents</h2>
            @if($featuredProducts->count() > 4)
            <a href="{{ route('products.index', ['featured' => true]) }}" class="text-sm font-semibold text-orange-500 hover:text-orange-600">
                View all featured contents <span aria-hidden="true">&rarr;</span>
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

</x-main-layout>