<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\DigitalProduct;
use App\Models\Page;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = collect([
            ['loc' => route('landing'), 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => route('about'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('contact'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('products.index'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => route('blog.index'), 'priority' => '0.8', 'changefreq' => 'daily'],
            ['loc' => route('seo.christian-audiobooks'), 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => route('seo.children-stories'), 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => route('seo.commuter-audiobooks'), 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => route('seo.inspiration-health'), 'priority' => '0.7', 'changefreq' => 'weekly'],
        ]);

        DigitalProduct::query()
            ->where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->get(['slug', 'updated_at'])
            ->each(fn ($p) => $urls->push([
                'loc' => route('products.show', $p),
                'lastmod' => $p->updated_at?->toAtomString(),
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ]));

        Blog::query()
            ->where('is_published', true)
            ->orderBy('updated_at', 'desc')
            ->get(['slug', 'updated_at'])
            ->each(fn ($b) => $urls->push([
                'loc' => route('blog.show', $b),
                'lastmod' => $b->updated_at?->toAtomString(),
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ]));

        Page::query()
            ->published()
            ->whereNotIn('slug', ['home'])
            ->orderBy('updated_at', 'desc')
            ->get(['slug', 'updated_at'])
            ->each(fn ($page) => $urls->push([
                'loc' => route('pages.show', $page->slug),
                'lastmod' => $page->updated_at?->toAtomString(),
                'priority' => '0.6',
                'changefreq' => 'monthly',
            ]));

        $xml = view('sitemap.index', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
