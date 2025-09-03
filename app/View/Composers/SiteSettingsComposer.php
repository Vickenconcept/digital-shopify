<?php

namespace App\View\Composers;

use App\Models\SiteSetting;
use Illuminate\View\View;

class SiteSettingsComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $siteSettings = SiteSetting::first();
        
        // Get weekly theme from site settings or use default
        $weeklyTheme = [
            'title' => $siteSettings->weekly_theme_title ?? 'Living That Spiritual Life – Awakening Your Spirit',
            'description' => $siteSettings->weekly_theme_description ?? 'Welcome to a space where transformation happens! Each week, we dive into topics that inspire spiritual awakening, deepen Kingdom relationships, and guide you on your journey toward spiritual growth. Ready to live with purpose? Start here.',
        ];

        // Get day-specific messages for rotation
        $dayMessages = [
            'monday' => $siteSettings->monday_message ?? '',
            'tuesday' => $siteSettings->tuesday_message ?? '',
            'wednesday' => $siteSettings->wednesday_message ?? '',
            'thursday' => $siteSettings->thursday_message ?? '',
            'friday' => $siteSettings->friday_message ?? '',
            'saturday' => $siteSettings->saturday_message ?? '',
            'sunday' => $siteSettings->sunday_message ?? '',
        ];

        // Get current day
        $currentDay = strtolower(now()->format('l')); // monday, tuesday, etc.
        
        $view->with([
            'siteSettings' => $siteSettings,
            'weeklyTheme' => $weeklyTheme,
            'dayMessages' => $dayMessages,
            'currentDay' => $currentDay
        ]);
    }
}
