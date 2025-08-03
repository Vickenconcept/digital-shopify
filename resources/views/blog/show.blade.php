<x-main-layout>
    <article class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Article Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ $blog->title }}
                </h1>
                <div class="flex items-center text-gray-500 dark:text-gray-400">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span class="sr-only">{{ $blog->user->name }}</span>
                            <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    {{ substr($blog->user->name, 0, 2) }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $blog->user->name }}
                            </p>
                            <div class="flex space-x-1 text-sm">
                                <time datetime="{{ $blog->created_at->format('Y-m-d') }}">
                                    {{ $blog->created_at->format('M d, Y') }}
                                </time>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            @if($blog->featured_image)
                <div class="mb-8">
                    <img class="w-full h-96 object-cover rounded-lg" src="{{ Storage::url($blog->featured_image) }}" alt="{{ $blog->title }}">
                </div>
            @endif

            <!-- Content -->
            <div class="prose dark:prose-invert max-w-none mb-12">
                {!! nl2br(e($blog->content)) !!}
            </div>

            <!-- YouTube Video -->
            @if($blog->youtube_url)
                <div class="mb-12">
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe 
                            src="{{ str_replace('watch?v=', 'embed/', $blog->youtube_url) }}" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            class="w-full h-full rounded-lg"
                        ></iframe>
                    </div>
                </div>
            @endif

            <!-- Related Posts -->
            @if($relatedPosts->isNotEmpty())
                <div class="border-t border-gray-200 dark:border-gray-700 pt-12">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">
                        Related Posts
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($relatedPosts as $post)
                            <x-blog-card :post="$post" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </article>
</x-main-layout>