<x-main-layout>
    <div class="min-h-[60vh] flex items-center justify-center px-6 py-16">
        <div class="max-w-lg text-center">
            <p class="text-7xl font-bold text-orange-500">404</p>
            <h1 class="mt-4 text-2xl font-bold text-gray-900">Page not found</h1>
            <p class="mt-3 text-gray-600">
                The page you are looking for may have moved, been removed, or never existed.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('landing') }}"
                   class="inline-flex items-center justify-center px-5 py-2.5 bg-orange-600 text-white text-sm font-semibold rounded-lg hover:bg-orange-700">
                    Back to home
                </a>
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50">
                    Browse products
                </a>
            </div>
        </div>
    </div>
</x-main-layout>
