<x-main-layout>
    @seo([
        'title' => 'Blog Archive | Your Journey Voices – All Inspiring Stories & Articles',
        'description' => 'Browse our complete collection of blog posts, articles, and reflections. Find inspiring Christian content, audiobook reviews, and personal growth stories.',
        'keywords' => 'blog archive, Christian articles, inspirational posts, audiobook reviews, faith stories, spiritual journey, personal growth blog',
        'image' => asset('images/blog-archive-og.jpg'),
        'site_name' => 'Your Journey Voices',
    ])

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Blog Archive
                </h2>
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">
                    Browse through our collection of articles, teachings, and reflections.
                </p>
            </div>

            <!-- Search Form -->
            <div class="mb-8">
                <form action="{{ route('blog.archive') }}" method="GET" class="flex gap-4">
                    <div class="flex-1">
                        <label for="search" class="sr-only">Search posts</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm"
                            placeholder="Search posts...">
                    </div>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('blog.archive') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            <!-- Posts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($posts as $post)
                    <x-blog-card :post="$post" />
                @empty
                    <div class="col-span-3 text-center py-12">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">No posts found</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Try adjusting your search or filter to find what you're looking for.
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-main-layout>