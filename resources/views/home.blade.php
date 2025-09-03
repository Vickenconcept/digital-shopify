<x-main-layout>
    <!-- Hero Section -->
    <div class="relative mt-5 mb-10">
            <div class="mx-auto w-full lg:grid lg:grid-cols-2 overflow-hidden rounded-2xl border border-gray-200 lg:w-[90%] shadow-2xl shadow-gray-100">
                <div class="pl-16 pr-10 pb-24 pt-20 sm:pb-32 lg:col-span-1 bg-black text-white">
                    <div class="mx-auto max-w-2xl lg:mx-0">
                        <!-- Dynamic Theme Title with Rotation -->
                        <div class="mt-24 sm:mt-10">
                            <h1 id="rotating-title" class="text-3xl font-semibold tracking-tight text-gray-50 sm:text-6xl">
                                {{ $weeklyTheme['title'] ?? 'Living That Spiritual Life – Awakening Your Spirit' }}
                            </h1>
                        </div>
                        
                        <p class="mt-6 text-lg leading-8 text-gray-100">{{ $weeklyTheme['description'] ?? 'Welcome to a space where transformation happens! Each week, we dive into topics that inspire spiritual awakening, deepen Kingdom relationships, and guide you on your journey toward spiritual growth. Ready to live with purpose? Start here.' }}</p>
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