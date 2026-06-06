<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>New Page — Page Builder</title>
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    @include('admin.pages._builder_assets')
</head>
<body>
<div id="pb-flash"></div>

<!-- ── Top bar ────────────────────────────────────────────────── -->
<div id="pb-topbar">
    <a href="{{ route('admin.pages.index') }}" class="pb-back">
        <i class="bx bx-arrow-back"></i> Pages
    </a>
    <div class="pb-divider"></div>

    <form id="pb-form" method="POST" action="{{ route('admin.pages.store') }}" style="display:contents;">
        @csrf

        <input id="pb-title-input" name="title" type="text"
               value="{{ old('title') }}" placeholder="Page title" required>
        <input id="pb-slug-input" name="slug" type="text"
               value="{{ old('slug') }}" placeholder="url-slug">

        <div class="pb-divider"></div>

        <div class="pb-toggles">
            <label class="pb-toggle-label">
                <input type="checkbox" name="is_published" value="1"
                       {{ old('is_published') ? 'checked' : '' }}>
                <span>Published</span>
            </label>
            <label class="pb-toggle-label">
                <input type="checkbox" name="show_in_navigation" value="1"
                       {{ old('show_in_navigation') ? 'checked' : '' }}>
                <span>Navbar</span>
            </label>
            <label class="pb-toggle-label">
                <input type="checkbox" name="show_in_footer" value="1"
                       {{ old('show_in_footer') ? 'checked' : '' }}>
                <span>Footer</span>
            </label>
        </div>

        <input type="hidden" name="body_html" id="body_html"
               value="{{ old('body_html', $page->body_html) }}">
        <input type="hidden" name="body_css" id="body_css"
               value="{{ old('body_css', $page->body_css) }}">
        <input type="hidden" name="custom_js" value="">

        <div class="pb-spacer"></div>

        <button type="submit" class="pb-save-btn">
            <i class="bx bx-save"></i> Create Page
        </button>
    </form>
</div>

<div id="gjs"></div>

<script>
window.PB_UPLOAD_URL   = '{{ route('admin.media.upload') }}';
window.PB_CSRF         = '{{ csrf_token() }}';
window.PB_FLASH_MSG    = null;
window.PB_INITIAL_HTML = {{ Js::from(old('body_html', $page->body_html)) }};
window.PB_INITIAL_CSS  = {{ Js::from(old('body_css',  $page->body_css))  }};
</script>
</body>
</html>
