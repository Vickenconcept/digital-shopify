<?php

namespace App\View\Composers;

use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\View\View;

class SiteSettingsComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        Page::ensureCorePagesExist();

        $siteSettings = SiteSetting::first();
        if (!$siteSettings) {
            $siteSettings = new SiteSetting();
        }

        $view->with([
            'siteSettings' => $siteSettings,
            'navigationPages' => Page::visibleInNavigation()
                ->orderByRaw("CASE WHEN slug = 'home' THEN 0 WHEN slug = 'about' THEN 1 ELSE 2 END")
                ->orderBy('title')
                ->get(),
            'footerPages' => Page::visibleInFooter()
                ->orderByRaw("CASE WHEN slug = 'home' THEN 0 WHEN slug = 'about' THEN 1 ELSE 2 END")
                ->orderBy('title')
                ->get(),
        ]);
    }
}
