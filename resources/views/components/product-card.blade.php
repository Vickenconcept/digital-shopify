<div class="group relative" x-data="{ 
    inWishlist: false,
    init() {
        // Check if product is in wishlist
        const wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
        this.inWishlist = wishlist.includes({{ $product->id }});
    },
    toggleWishlist(e) {
        // Prevent the click from bubbling up to the parent link
        e.preventDefault();
        e.stopPropagation();
        
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
    addToCart(e) {
        // Prevent the click from bubbling up to the parent link
        e.preventDefault();
        e.stopPropagation();
        
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
    <div class="relative h-64 w-full overflow-hidden rounded-lg bg-gray-200">
        <a href="{{ route('products.show', $product) }}" class="block h-full">
            <div class="h-full w-full flex items-center justify-center">
                <img src="{{ $product->thumbnail_path }}" alt="{{ $product->title }}" class="h-full w-full object-contain">
            </div>
        </a>
        <button @click="toggleWishlist($event)" type="button" class="absolute top-2 right-2 p-2 rounded-full bg-white shadow-sm z-10 hover:bg-gray-100">
            <svg x-show="!inWishlist" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <svg x-show="inWishlist" class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L12 8.343l3.172-3.171a4 4 0 115.656 5.656L12 19.657l-8.828-8.829a4 4 0 010-5.656z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    <div class="mt-4 space-y-2">
        <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
                <h3 class="text-sm font-medium text-gray-900 truncate">
                    <a href="{{ route('products.show', $product) }}" class="hover:text-indigo-600">
                        {{ $product->title }}
                    </a>
                </h3>
                <p class="mt-1 text-sm text-gray-500">{{ ucfirst($product->file_type) }}</p>
                @if($product->author)
                    <p class="mt-1 text-xs text-gray-500">by {{ $product->author }}</p>
                @endif
            </div>
            <div class="flex-shrink-0 ml-2">
                @if($product->is_free)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Free Resource
                    </span>
                @else
                    <p class="text-sm font-medium text-gray-900">${{ number_format($product->price, 2) }}</p>
                @endif
            </div>
        </div>
        
        @if($product->is_free)
            <a href="{{ route('download.product', $product) }}" 
               target="_blank"
               class="w-full rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 text-center">
                Download Now
            </a>
        @elseif($showAddToCart)
            <button @click="addToCart($event)" type="button" class="w-full rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Add to Cart
            </button>
        @endif
    </div>
</div>