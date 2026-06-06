<x-main-layout>
    @seo([
        'title' => ($page->meta_title ?: $page->title) . ' | Your Journey Voices',
        'description' => $page->meta_description ?: ('Your Journey Voices — ' . $page->title),
        'image' => $page->og_image ?: asset('images/your-journey-voices-og.jpg'),
        'site_name' => 'Your Journey Voices',
    ])

    <section class="pb-6 cms-page-content">
        @if($page->body_css)
            <style>{!! $page->body_css !!}</style>
        @endif

        {!! $page->body_html !!}
    </section>

    @if($page->custom_js)
        @push('scripts')
            <script>{!! $page->custom_js !!}</script>
        @endpush
    @endif
</x-main-layout>
