<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Response;

class PageController extends Controller
{
    /** Slugs that must not be used for custom CMS pages (handled by dedicated routes). */
    private const RESERVED_SLUGS = [
        'blog', 'contact', 'products', 'login', 'register', 'admin',
        'payment', 'download', 'content', 'stream', 'auth', 'user', 'home', 'about',
        'christian-audiobooks', 'children-audiobooks', 'commuter-audiobooks', 'inspiration-health',
    ];

    public function home()
    {
        Page::ensureCorePagesExist();

        $page = Page::published()->where('slug', 'home')->firstOrFail();

        return view('pages.show', compact('page'));
    }

    public function about()
    {
        Page::ensureCorePagesExist();

        $page = Page::published()->where('slug', 'about')->firstOrFail();

        return view('pages.show', compact('page'));
    }

    public function show(string $slug)
    {
        $page = Page::published()
            ->where('slug', $slug)
            ->first();

        if (!$page || in_array($slug, self::RESERVED_SLUGS, true)) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return view('pages.show', compact('page'));
    }
}
