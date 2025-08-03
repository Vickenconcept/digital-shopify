<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class SiteSetting extends Model
{
    protected $fillable = [
        'weekly_theme_title',
        'weekly_theme_description',
        'weekly_theme_start_date',
        'monday_message',
        'tuesday_message',
        'wednesday_message',
        'thursday_message',
        'friday_message',
        'saturday_message',
        'sunday_message',
        'cta_title',
        'cta_description',
        'cta_button_text',
        'cta_button_link',
        'facebook_link',
        'twitter_link',
        'instagram_link',
        'youtube_link',
        'tiktok_link',
        'hero_image_1',
        'hero_image_2',
        'hero_image_3',
        'banner_image_1',
        'banner_image_2',
        'banner_image_3',
    ];

    protected $casts = [
        'weekly_theme_start_date' => 'date',
    ];

    public function isCurrentWeeklyTheme(): bool
    {
        if (!$this->weekly_theme_start_date) {
            return false;
        }

        $startDate = Carbon::parse($this->weekly_theme_start_date);
        $endDate = $startDate->copy()->addWeek();
        
        return now()->between($startDate, $endDate);
    }
}