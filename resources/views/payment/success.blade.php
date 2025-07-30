<x-main-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Payment Successful!
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Thank you for your purchase. Your order has been processed successfully.
                </p>
            </div>
            
            <div class="mt-8 space-y-4">
                <a href="{{ route('user.orders') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    View My Orders
                </a>
                <a href="{{ route('home') }}" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>

    <!-- Clear cart from localStorage -->
    <script>
        // Clear the cart from localStorage since payment was successful
        localStorage.removeItem('cart');
        
        // Dispatch event to update cart display
        window.dispatchEvent(new CustomEvent('cart-updated'));
        
        // Show success message
        console.log('Payment successful, cart cleared');
    </script>
</x-main-layout>