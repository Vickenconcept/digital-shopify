<x-main-layout>
    @seo([
        'title' => 'Audiobooks for Commuters | Listen to Stories While Driving or Traveling',
        'description' => 'Make your commute meaningful with uplifting audiobooks. Perfect for daily drives, long trips, and travelers who love stories on the go.',
        'keywords' => 'audiobooks for commuters, listen to books while driving, inspirational commute audiobooks, best books for long drives, audio stories for busy parents, uplifting stories for daily commute',
        'image' => asset('images/commuter-audiobooks-og.jpg'),
        'site_name' => 'Your Journey Voices',
    ])

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-green-600 to-blue-600 text-white py-16">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Audiobooks for Commuters
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-green-100">
                    Listen to Stories While Driving or Traveling
                </p>
                <p class="text-lg mb-8 text-green-200">
                    Make your commute meaningful with uplifting audiobooks. Perfect for daily drives, long trips, and travelers who love stories on the go.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#featured" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                        Browse Featured Audiobooks
                    </a>
                    <a href="#all-products" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-green-600 px-8 py-3 rounded-lg font-semibold transition-colors">
                        View All Commuter Content
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
                    Featured Commuter Audiobooks
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Transform your daily commute with these inspiring audiobooks that make every drive meaningful and productive.
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
                    All Commuter Audiobooks
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Browse our complete collection of audiobooks perfect for commuters, travelers, and anyone who loves stories on the go.
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
                    <p class="text-lg text-gray-600">No commuter audiobooks found at the moment. Check back soon for new content!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Commute Types Section -->
    <section class="py-16 bg-green-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Perfect for Every Type of Commute
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Whether you're driving to work, taking public transit, or going on a road trip, we have the perfect audiobooks for your journey.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg p-8 shadow-lg text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Daily Commute</h3>
                    <p class="text-gray-600">Short, engaging audiobooks perfect for your daily drive to work. Make traffic time productive and inspiring.</p>
                </div>
                
                <div class="bg-white rounded-lg p-8 shadow-lg text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Long Road Trips</h3>
                    <p class="text-gray-600">Epic stories and series perfect for long drives. Keep the whole family entertained on your next adventure.</p>
                </div>
                
                <div class="bg-white rounded-lg p-8 shadow-lg text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Public Transit</h3>
                    <p class="text-gray-600">Perfect for bus rides, train commutes, and flights. Transform your travel time into learning and inspiration time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Why Commuters Love Our Audiobooks
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Time Efficient</h3>
                    <p class="text-gray-600">Turn your commute into productive time. Learn, grow, and be inspired while you travel.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Stress Relief</h3>
                    <p class="text-gray-600">Uplifting stories help reduce commute stress and start your day with positivity.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Energy Boost</h3>
                    <p class="text-gray-600">Motivational content gives you the energy and inspiration you need for a great day.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Easy Listening</h3>
                    <p class="text-gray-600">High-quality narration and engaging content that's perfect for focused listening while driving.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-green-600 to-blue-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                Transform Your Commute Today
            </h2>
            <p class="text-xl mb-8 text-green-100">
                Join thousands of commuters who are making their daily drives more meaningful with our inspiring audiobooks.
            </p>
            <a href="{{ route('products.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors inline-block">
                Browse All Commuter Audiobooks
            </a>
        </div>
    </section>
</x-main-layout>
