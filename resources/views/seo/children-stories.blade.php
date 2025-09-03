<x-main-layout>
    @seo([
        'title' => 'Children\'s Audiobooks & Bedtime Stories | Family-Friendly Ebooks',
        'description' => 'Bring stories to life for kids with audiobooks and ebooks. Bedtime stories, Bible tales, and fairytales – safe and inspiring for the whole family.',
        'keywords' => 'children\'s audiobooks online, bedtime story audiobooks for kids, ebooks for young readers, audio fairytales for children, Christian children\'s audiobooks, family friendly audiobook library',
        'image' => asset('images/children-stories-og.jpg'),
        'site_name' => 'Your Journey Voices',
    ])

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-pink-500 to-purple-600 text-white py-16">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Children's Audiobooks & Bedtime Stories
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-pink-100">
                    Family-Friendly Ebooks & Audio Stories
                </p>
                <p class="text-lg mb-8 text-pink-200">
                    Bring stories to life for kids with audiobooks and ebooks. Bedtime stories, Bible tales, and fairytales – safe and inspiring for the whole family.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#featured" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                        Browse Featured Stories
                    </a>
                    <a href="#all-products" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-pink-600 px-8 py-3 rounded-lg font-semibold transition-colors">
                        View All Children's Content
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
                    Featured Children's Stories
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Discover our most beloved bedtime stories, Bible tales, and educational content that kids love and parents trust.
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
                    All Children's Audiobooks & Ebooks
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Browse our complete collection of children's stories, bedtime tales, and educational content for kids of all ages.
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
                    <p class="text-lg text-gray-600">No children's stories found at the moment. Check back soon for new content!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Age Categories Section -->
    <section class="py-16 bg-pink-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Stories for Every Age
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    From toddlers to tweens, we have age-appropriate content that entertains, educates, and inspires.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg p-8 shadow-lg text-center">
                    <div class="bg-pink-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Ages 2-5</h3>
                    <p class="text-gray-600">Simple bedtime stories, nursery rhymes, and basic Bible stories perfect for toddlers and preschoolers.</p>
                </div>
                
                <div class="bg-white rounded-lg p-8 shadow-lg text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Ages 6-9</h3>
                    <p class="text-gray-600">Adventure stories, educational content, and age-appropriate Bible stories that engage young readers.</p>
                </div>
                
                <div class="bg-white rounded-lg p-8 shadow-lg text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Ages 10+</h3>
                    <p class="text-gray-600">Chapter books, educational series, and inspiring stories that challenge and motivate older children.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Why Parents Love Our Children's Content
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-pink-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Safe & Clean</h3>
                    <p class="text-gray-600">All content is carefully curated to be appropriate for children of all ages.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Educational</h3>
                    <p class="text-gray-600">Stories that teach valuable lessons while entertaining and engaging young minds.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Family Bonding</h3>
                    <p class="text-gray-600">Perfect for bedtime routines, car rides, and quality family time together.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Screen-Free Fun</h3>
                    <p class="text-gray-600">Encourage imagination and creativity without screen time. Perfect for digital detox moments.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-pink-500 to-purple-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                Start Your Family's Story Journey
            </h2>
            <p class="text-xl mb-8 text-pink-100">
                Join thousands of families who are creating magical moments with our children's audiobooks and bedtime stories.
            </p>
            <a href="{{ route('products.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors inline-block">
                Browse All Children's Content
            </a>
        </div>
    </section>
</x-main-layout>
