<x-main-layout>
    @seo([
        'title' => 'Christian Audiobooks Online | Faith-Based Stories & Bible Dramatizations',
        'description' => 'Explore inspiring Christian audiobooks, Bible stories, and faith-based ebooks. Listen anywhere and strengthen your faith with Your Journey Voices.',
        'keywords' => 'Christian audiobooks online, Bible stories for adults, faith based ebooks for families, inspirational faith stories audio, Christian bedtime stories for children, biblical dramatizations audiobook',
        'image' => asset('images/christian-audiobooks-og.jpg'),
        'site_name' => 'Your Journey Voices',
    ])

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-blue-900 to-purple-900 text-white py-16">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Christian Audiobooks Online
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">
                    Faith-Based Stories & Bible Dramatizations
                </p>
                <p class="text-lg mb-8 text-blue-200">
                    Explore inspiring Christian audiobooks, Bible stories, and faith-based ebooks. Listen anywhere and strengthen your faith with Your Journey Voices.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#featured" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                        Browse Featured Content
                    </a>
                    <a href="#all-products" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-blue-900 px-8 py-3 rounded-lg font-semibold transition-colors">
                        View All Christian Audiobooks
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products Section -->
    @if($featuredProducts->isNotEmpty())
    <section id="featured" class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Featured Christian Audiobooks
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Discover our most popular faith-based audiobooks and Bible stories that inspire spiritual growth and strengthen your relationship with God.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- All Products Section -->
    <section id="all-products" class="py-16">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    All Christian Audiobooks & Ebooks
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Browse our complete collection of Christian audiobooks, Bible stories, and faith-based content for adults and families.
                </p>
            </div>

            @if($products->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-12">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-lg text-gray-600">No Christian audiobooks found at the moment. Check back soon for new content!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-16 bg-blue-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Why Choose Our Christian Audiobooks?
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Bible-Based Content</h3>
                    <p class="text-gray-600">All our Christian audiobooks are rooted in biblical truth and designed to strengthen your faith journey.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Listen Anywhere</h3>
                    <p class="text-gray-600">Perfect for commutes, workouts, or quiet time. Take your faith journey with you wherever you go.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Family-Friendly</h3>
                    <p class="text-gray-600">Safe, inspiring content for all ages. Perfect for family listening and children's spiritual development.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                Start Your Faith Journey Today
            </h2>
            <p class="text-xl mb-8 text-blue-100">
                Join thousands of believers who are strengthening their faith through our Christian audiobooks and Bible stories.
            </p>
            <a href="{{ route('products.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors inline-block">
                Browse All Christian Content
            </a>
        </div>
    </section>
</x-main-layout>
