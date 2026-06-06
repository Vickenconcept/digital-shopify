<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(Request $request): View
    {
        Page::ensureCorePagesExist();

        $query = Page::query()->latest();

        if ($request->filled('search')) {
            $query->where(function ($builder) use ($request): void {
                $builder
                    ->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('slug', 'like', '%' . $request->search . '%');
            });
        }

        $pages = $query->paginate(15)->withQueryString();

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        $page = new Page([
            'is_published' => false,
            'show_in_navigation' => false,
            'show_in_footer' => false,
            'body_html' => Page::defaultCreatePageHtml(),
            'body_css' => Page::defaultCreatePageCss(),
            'custom_js' => '',
        ]);

        return view('admin.pages.create', compact('page'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePage($request);

        $validated['slug'] = Str::slug($validated['slug'] ?: $validated['title']);
        $validated['is_system'] = false;
        $validated['is_published'] = $request->boolean('is_published');
        $validated['show_in_navigation'] = $request->boolean('show_in_navigation');
        $validated['show_in_footer'] = $request->boolean('show_in_footer');

        $page = Page::create($validated);

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Page created successfully.');
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $validated = $this->validatePage($request, $page->id, $page->is_system);

        if ($page->is_system) {
            $validated['slug'] = $page->slug;
        } else {
            $validated['slug'] = Str::slug($validated['slug'] ?: $validated['title']);
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['show_in_navigation'] = $request->boolean('show_in_navigation');
        $validated['show_in_footer'] = $request->boolean('show_in_footer');

        $page->update($validated);

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        if ($page->is_system) {
            return redirect()
                ->route('admin.pages.index')
                ->with('error', 'System pages cannot be deleted.');
        }

        $page->delete();

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }

    private function validatePage(Request $request, ?int $ignoreId = null, bool $isSystem = false): array
    {
        $slugRules = ['nullable', 'string', 'max:255', Rule::unique('pages', 'slug')->ignore($ignoreId)];

        if ($isSystem) {
            $slugRules = ['nullable'];
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => $slugRules,
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'url', 'max:500'],
            'body_html' => ['nullable', 'string'],
            'body_css' => ['nullable', 'string'],
            'custom_js' => ['nullable', 'string'],
        ]);
    }
}
