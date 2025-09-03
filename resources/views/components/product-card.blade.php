<div class="group relative" x-data="{
    inWishlist: false,
    productId: {{ $product->id }},
    productTitle: '{{ addslashes($product->title) }}',
    productPrice: {{ $product->price }},
    productThumbnail: '{{ addslashes($product->thumbnail_path) }}',
    init() {
        // Check if product is in wishlist
        try {
            const wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
            this.inWishlist = wishlist.includes(this.productId);
        } catch (e) {
            console.error('Error parsing wishlist:', e);
            this.inWishlist = false;
        }
    },
    toggleWishlist(e) {
        // Prevent the click from bubbling up to the parent link
        e.preventDefault();
        e.stopPropagation();

        try {
            let wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
            if (this.inWishlist) {
                wishlist = wishlist.filter(id => id !== this.productId);
            } else {
                wishlist.push(this.productId);
            }
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            this.inWishlist = !this.inWishlist;

            // Dispatch event for wishlist update
            window.dispatchEvent(new CustomEvent('wishlist-updated'));
        } catch (e) {
            console.error('Error updating wishlist:', e);
        }
    },
    addToCart(e) {
        // Prevent the click from bubbling up to the parent link
        e.preventDefault();
        e.stopPropagation();

        try {
            let cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const existingItem = cart.find(item => item.id === this.productId);

            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    id: this.productId,
                    title: this.productTitle,
                    price: this.productPrice,
                    thumbnail: this.productThumbnail,
                    quantity: 1
                });
            }

            localStorage.setItem('cart', JSON.stringify(cart));

            // Dispatch event for cart update
            window.dispatchEvent(new CustomEvent('cart-updated'));
        } catch (e) {
            console.error('Error updating cart:', e);
        }
    }
}">
    <div class="relative h-64 w-full overflow-hidden rounded-lg bg-gray-200">
        <a href="{{ route('products.show', $product) }}" class="block h-full">
            <div class="h-full w-full flex items-center justify-center">
                <img src="{{ $product->thumbnail_path }}" alt="{{ $product->title }}"
                    class="h-full w-full object-contain">
            </div>
        </a>
        <button @click="toggleWishlist($event)" type="button"
            class="absolute top-2 right-2 p-2 rounded-full bg-white shadow-sm z-10 hover:bg-gray-100">
            <svg x-show="!inWishlist" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6 text-gray-600">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
            </svg>
            <svg x-show="inWishlist" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="red" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
            </svg>
        </button>
    </div>
    <div class="mt-4 space-y-2">
        <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
                <h3 class="text-sm font-medium text-gray-900 truncate">
                    <a href="{{ route('products.show', $product) }}" class="hover:text-orange-500">
                        {{ $product->title }}
                    </a>
                </h3>
                <p class="mt-1 text-sm text-gray-500">{{ ucfirst($product->file_type) }}</p>
                @if ($product->author)
                    <p class="mt-1 text-xs text-gray-500">by {{ $product->author }}</p>
                @endif
            </div>
            <div class="flex-shrink-0 ml-2">
                @if ($product->is_free)
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-black text-white">
                        Free Resource
                    </span>
                @else
                    <p class="text-sm font-medium text-gray-900">${{ number_format($product->price, 2) }}</p>
                @endif
            </div>
        </div>

        @if ($product->is_free)
            <a href="{{ route('download.product', $product) }}" target="_blank"
                class="w-full rounded-md bg-orange-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-500 text-center">
                Download Now
            </a>
        @elseif($showAddToCart)
            <button @click="addToCart($event)" type="button"
                class="w-full rounded-md bg-orange-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-500">
                Add to Cart
            </button>
        @endif
    </div>
</div>
