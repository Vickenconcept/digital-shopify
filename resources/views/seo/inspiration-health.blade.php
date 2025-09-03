<x-main-layout>
    @seo([
        'title' => 'Inspirational & Self-Improvement Audiobooks | Personal Growth Stories',
        'description' => 'Find motivational audiobooks and ebooks to boost your health, wellness, and mindset. Uplifting stories designed to encourage personal growth.',
        'keywords' => 'self improvement audiobooks online, inspirational ebooks and stories, motivational audiobook collection, healthy living audiobooks, mental wellness audio stories, uplifting ebooks for women',
        'image' => asset('images/inspiration-health-og.jpg'),
        'site_name' => 'Your Journey Voices',
    ])

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-purple-600 to-pink-600 text-white py-16">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Inspirational & Self-Improvement Audiobooks
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-purple-100">
                    Personal Growth Stories
                </p>
                <p class="text-lg mb-8 text-purple-200">
                    Find motivational audiobooks and ebooks to boost your health, wellness, and mindset. Uplifting stories designed to encourage personal growth.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#featured" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                        Browse Featured Content
                    </a>
                    <a href="#all-products" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-purple-600 px-8 py-3 rounded-lg font-semibold transition-colors">
                        View All Inspiration Content
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
                    Featured Inspirational Content
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Discover our most powerful motivational audiobooks and ebooks that inspire personal growth, wellness, and positive mindset transformation.
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
                    All Inspirational & Health Content
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Browse our complete collection of motivational audiobooks, wellness ebooks, and personal development content.
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
                    <p class="text-lg text-gray-600">No inspirational content found at the moment. Check back soon for new content!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-purple-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Areas of Personal Growth
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Explore different aspects of personal development and wellness through our carefully curated content categories.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white rounded-lg p-8 shadow-lg text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Mental Wellness</h3>
                    <p class="text-gray-600">Content focused on mental health, stress management, and emotional well-being.</p>
                </div>
                
                <div class="bg-white rounded-lg p-8 shadow-lg text-center">
                    <div class="bg-pink-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Motivation</h3>
                    <p class="text-gray-600">Inspiring stories and strategies to boost motivation and achieve your goals.</p>
                </div>
                
                <div class="bg-white rounded-lg p-8 shadow-lg text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Health & Wellness</h3>
                    <p class="text-gray-600">Content about physical health, nutrition, fitness, and overall wellness.</p>
                </div>
                
                <div class="bg-white rounded-lg p-8 shadow-lg text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Self-Improvement</h3>
                    <p class="text-gray-600">Practical guides and strategies for personal development and life improvement.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Transform Your Life with Inspirational Content
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Mental Clarity</h3>
                    <p class="text-gray-600">Gain mental clarity and focus through inspiring stories and practical wisdom.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-pink-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Emotional Wellness</h3>
                    <p class="text-gray-600">Build emotional resilience and find inner peace through uplifting content.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Goal Achievement</h3>
                    <p class="text-gray-600">Learn strategies and gain motivation to achieve your personal and professional goals.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-purple-600 to-pink-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                Start Your Personal Growth Journey
            </h2>
            <p class="text-xl mb-8 text-purple-100">
                Join thousands of people who are transforming their lives through our inspirational audiobooks and personal development content.
            </p>
            <a href="{{ route('products.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors inline-block">
                Browse All Inspirational Content
            </a>
        </div>
    </section>
</x-main-layout>
