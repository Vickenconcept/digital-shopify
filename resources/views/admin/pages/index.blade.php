<x-admin-layout>
<div class="space-y-6">

    {{-- ── Header ──────────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pages</h1>
            <p class="text-sm text-gray-500 mt-1">Build and manage your site pages with the GrapesJS visual editor.</p>
        </div>
        <a href="{{ route('admin.pages.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-500 text-white text-sm font-semibold rounded-lg hover:bg-orange-600 transition-colors shadow-sm shadow-orange-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Page
        </a>
    </div>

    {{-- ── Flash messages ──────────────────────────────────────── --}}
    @if(session('success'))
        <div class="flex items-center gap-3 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            <svg class="w-4 h-4 shrink-0 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
            <svg class="w-4 h-4 shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Stats ───────────────────────────────────────────────── --}}
    @php
        $allPages   = $pages->getCollection();
        $published  = $allPages->where('is_published', true)->count();
        $drafts     = $allPages->where('is_published', false)->count();
        $inNav      = $allPages->where('show_in_navigation', true)->count();
    @endphp
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm px-5 py-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Pages</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $pages->total() }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm px-5 py-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Published</p>
            <p class="text-3xl font-bold text-green-600 mt-1">{{ $published }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm px-5 py-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Drafts</p>
            <p class="text-3xl font-bold text-yellow-500 mt-1">{{ $drafts }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm px-5 py-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">In Navigation</p>
            <p class="text-3xl font-bold text-orange-500 mt-1">{{ $inNav }}</p>
        </div>
    </div>

    {{-- ── Search + table card ──────────────────────────────────── --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">

        {{-- Search bar --}}
        <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center gap-3">
            <form method="GET" class="flex items-center gap-3 flex-1">
                <div class="relative flex-1 max-w-sm">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search pages by title or slug…"
                           class="w-full pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-orange-500">
                </div>
                <button type="submit"
                        class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.pages.index') }}"
                       class="px-4 py-2 border border-gray-300 text-gray-600 text-sm rounded-lg hover:bg-gray-50 transition-colors">
                        Clear
                    </a>
                @endif
            </form>

            <div class="text-sm text-gray-400 shrink-0">
                {{ $pages->total() }} {{ Str::plural('page', $pages->total()) }}
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Page</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Visibility</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Last Updated</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($pages as $page)
                        <tr class="hover:bg-gray-50/60 transition-colors group">

                            {{-- Page title + URL --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0
                                        {{ $page->is_system ? 'bg-purple-100' : 'bg-orange-50' }}">
                                        @if($page->is_system)
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-gray-900 text-sm">{{ $page->title }}</span>
                                            @if($page->is_system)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-semibold bg-purple-100 text-purple-700">System</span>
                                            @endif
                                        </div>
                                        <a href="{{ $page->url }}" target="_blank"
                                           class="text-xs text-gray-400 hover:text-orange-500 transition-colors flex items-center gap-1 mt-0.5">
                                            {{ $page->url }}
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @if($page->is_published)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-50 text-yellow-700 border border-yellow-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span>
                                        Draft
                                    </span>
                                @endif
                            </td>

                            {{-- Visibility chips --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 flex-wrap">
                                    @if($page->show_in_navigation)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                            </svg>
                                            Navbar
                                        </span>
                                    @endif
                                    @if($page->show_in_footer)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18"/>
                                            </svg>
                                            Footer
                                        </span>
                                    @endif
                                    @if(!$page->show_in_navigation && !$page->show_in_footer)
                                        <span class="text-xs text-gray-400">Hidden</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Last updated --}}
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500">{{ $page->updated_at->diffForHumans() }}</span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">

                                    {{-- Preview --}}
                                    <a href="{{ $page->url }}" target="_blank"
                                       title="Preview page"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        View
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.pages.edit', $page) }}"
                                       title="Edit in page builder"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-orange-500 rounded-lg hover:bg-orange-600 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>

                                    {{-- Delete (custom pages only) --}}
                                    @if(!$page->is_system)
                                        <form method="POST" action="{{ route('admin.pages.destroy', $page) }}"
                                              onsubmit="return confirm('Delete "{{ addslashes($page->title) }}"? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    title="Delete page"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 border border-red-100 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    @else
                                        <span title="System pages cannot be deleted"
                                              class="inline-flex items-center px-3 py-1.5 text-xs text-gray-300 bg-gray-50 rounded-lg border border-gray-100 cursor-not-allowed select-none">
                                            Protected
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-700">No pages found</p>
                                        <p class="text-sm text-gray-400 mt-1">
                                            @if(request('search'))
                                                No results for "{{ request('search') }}" —
                                                <a href="{{ route('admin.pages.index') }}" class="text-orange-500 hover:underline">clear search</a>
                                            @else
                                                Get started by creating your first page.
                                            @endif
                                        </p>
                                    </div>
                                    @unless(request('search'))
                                        <a href="{{ route('admin.pages.create') }}"
                                           class="mt-1 inline-flex items-center gap-2 px-4 py-2 bg-orange-500 text-white text-sm font-semibold rounded-lg hover:bg-orange-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Create First Page
                                        </a>
                                    @endunless
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pages->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $pages->links() }}
            </div>
        @endif
    </div>

</div>
</x-admin-layout>
