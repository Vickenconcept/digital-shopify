@props(['post'])

<article class="flex flex-col overflow-hidden rounded-lg shadow-lg">
    <div class="flex-shrink-0">
        @if($post->featured_image)
            <img class="h-48 w-full object-cover" src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}">
        @else
            <div class="h-48 w-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        @endif
    </div>
    <div class="flex flex-1 flex-col justify-between bg-white dark:bg-gray-800 p-6">
        <div class="flex-1">
            <a href="{{ route('blog.show', $post) }}" class="block mt-2">
                <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $post->title }}</p>
                <p class="mt-3 text-base text-gray-500 dark:text-gray-300">
                    {{ Str::limit($post->excerpt ?? strip_tags($post->content), 150) }}
                </p>
            </a>
        </div>
        <div class="mt-6 flex items-center">
            <div class="flex-shrink-0">
                <span class="sr-only">{{ $post->user->name }}</span>
                <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ substr($post->user->name, 0, 2) }}
                    </span>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900 dark:text-white">
                    {{ $post->user->name }}
                </p>
                <div class="flex space-x-1 text-sm text-gray-500 dark:text-gray-400">
                    <time datetime="{{ $post->created_at->format('Y-m-d') }}">
                        {{ $post->created_at->format('M d, Y') }}
                    </time>
                    @if($post->is_featured)
                        <span aria-hidden="true">&middot;</span>
                        <span class="text-indigo-600 dark:text-indigo-400">Featured</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</article>