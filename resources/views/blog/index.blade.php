<x-main-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Featured Posts -->
            @if($featuredPosts->isNotEmpty())
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900  mb-8">
                        Featured Posts
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($featuredPosts as $post)
                            <x-blog-card :post="$post" />
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Latest Posts -->
            <div>
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 ">
                        Latest Posts
                    </h2>
                    <a href="{{ route('blog.archive') }}"
                        class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                        View Archive &rarr;
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($latestPosts as $post)
                        <x-blog-card :post="$post" />
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $latestPosts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-main-layout>