<?php

namespace App\Support;

use App\Models\SiteSetting;

class AdminNotifications
{
    public static function isEnabled(string $event): bool
    {
        $settings = SiteSetting::first();

        if (!$settings) {
            return true;
        }

        return match ($event) {
            'new_order' => (bool) ($settings->notify_admin_new_order ?? true),
            'new_user' => (bool) ($settings->notify_admin_new_user ?? true),
            'contact' => (bool) ($settings->notify_admin_contact ?? true),
            default => true,
        };
    }
}
