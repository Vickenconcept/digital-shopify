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
        if (!$siteSettings) {
            $siteSettings = new SiteSetting();
        }
        
        // Get weekly theme from site settings or use default
        $weeklyTheme = [
            'title' => $siteSettings->weekly_theme_title ?? 'Your Journey Voices – Stories That Travel With You',
            'description' => $siteSettings->weekly_theme_description ?? 'Discover inspiring Christian audiobooks, children\'s bedtime stories, and motivational content perfect for commuters. Your Journey Voices brings you stories that inspire, educate, and travel with you wherever life takes you.',
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
