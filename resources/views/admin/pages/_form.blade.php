@php
    $isEditing = $page->exists;
@endphp

<div class="space-y-6">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Page Title</label>
                <input id="title" name="title" type="text" value="{{ old('title', $page->title) }}" required
                    class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500">
            </div>
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug (URL)</label>
                <input id="slug" name="slug" type="text" value="{{ old('slug', $page->slug) }}"
                    @if($page->is_system) readonly @endif
                    class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 @if($page->is_system) bg-gray-100 @endif">
                <p class="text-xs text-gray-500 mt-1">Example: <code>about</code> becomes <code>/about</code>.</p>
            </div>
        </div>

        @include('admin.partials.seo-fields', ['model' => $page])

        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_published" value="1"
                    {{ old('is_published', $page->is_published) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                <span class="ml-2 text-sm text-gray-700">Published</span>
            </label>
            <label class="inline-flex items-center">
                <input type="checkbox" name="show_in_navigation" value="1"
                    {{ old('show_in_navigation', $page->show_in_navigation) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                <span class="ml-2 text-sm text-gray-700">Show in navbar</span>
            </label>
            <label class="inline-flex items-center">
                <input type="checkbox" name="show_in_footer" value="1"
                    {{ old('show_in_footer', $page->show_in_footer) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                <span class="ml-2 text-sm text-gray-700">Show in footer</span>
            </label>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Page Builder</h3>
            <p class="text-sm text-gray-500 mt-1">Edit only the page body. Navbar and footer remain from your site layout.</p>
        </div>
        <div id="gjs-editor" style="height: 75vh;"></div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <label for="custom_js" class="block text-sm font-medium text-gray-700 mb-2">Optional Page JavaScript</label>
        <textarea id="custom_js" name="custom_js" rows="5"
            class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500">{{ old('custom_js', $page->custom_js) }}</textarea>
    </div>

    <input type="hidden" name="body_html" id="body_html" value="{{ old('body_html', $page->body_html) }}">
    <input type="hidden" name="body_css" id="body_css" value="{{ old('body_css', $page->body_css) }}">

    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.pages.index') }}"
            class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">Cancel</a>
        <button type="submit"
            class="px-5 py-2 rounded-lg bg-orange-500 text-white hover:bg-orange-600">
            {{ $isEditing ? 'Update Page' : 'Create Page' }}
        </button>
    </div>
</div>

@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    <script src="https://unpkg.com/grapesjs"></script>
    <script src="https://unpkg.com/grapesjs-preset-webpage"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editor = grapesjs.init({
                container: '#gjs-editor',
                height: '75vh',
                fromElement: false,
                storageManager: false,
                plugins: ['gjs-preset-webpage'],
                pluginsOpts: {
                    'gjs-preset-webpage': {}
                },
                canvas: {
                    styles: [],
                }
            });

            const initialHtml = document.getElementById('body_html').value || '<section><h1>Start designing your page</h1></section>';
            const initialCss = document.getElementById('body_css').value || '';

            editor.setComponents(initialHtml);
            editor.setStyle(initialCss);

            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');
            if (titleInput && slugInput && !slugInput.readOnly) {
                titleInput.addEventListener('input', () => {
                    if (slugInput.dataset.edited === '1') {
                        return;
                    }

                    slugInput.value = titleInput.value
                        .toLowerCase()
                        .trim()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
                });

                slugInput.addEventListener('input', () => {
                    slugInput.dataset.edited = '1';
                });
            }

            document.querySelector('form').addEventListener('submit', function () {
                document.getElementById('body_html').value = editor.getHtml();
                document.getElementById('body_css').value = editor.getCss();
            });
        });
    </script>
@endpush
