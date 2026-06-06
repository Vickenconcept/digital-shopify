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
        'cta_button_text',
        'facebook_link',
        'twitter_link',
        'instagram_link',
        'youtube_link',
        'tiktok_link',
        'contact_email',
        'contact_phone',
        'contact_address',
        'notify_admin_new_order',
        'notify_admin_new_user',
        'notify_admin_contact',
        'audit_log_retention_days',
        'tax_rate',
        'hero_image_1',
        'hero_image_2',
        'hero_image_3',
        'banner_image_1',
        'banner_image_2',
        'banner_image_3',
    ];

    protected $casts = [
        'weekly_theme_start_date' => 'date',
        'notify_admin_new_order' => 'boolean',
        'notify_admin_new_user' => 'boolean',
        'notify_admin_contact' => 'boolean',
        'audit_log_retention_days' => 'integer',
        'tax_rate' => 'decimal:2',
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