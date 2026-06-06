<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SiteSetting;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function __construct(
        private readonly ActivityLogger $activityLogger,
    ) {}
    public function index()
    {
        $settings = SiteSetting::firstOrCreate([]);
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = SiteSetting::firstOrCreate([]);
        
        $validated = $request->validate([
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:1000',
            'notify_admin_new_order' => 'sometimes|boolean',
            'notify_admin_new_user' => 'sometimes|boolean',
            'notify_admin_contact' => 'sometimes|boolean',
            'audit_log_retention_days' => 'nullable|integer|min:0|max:3650',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'facebook_link' => 'nullable|url|max:255',
            'twitter_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url|max:255',
            'youtube_link' => 'nullable|url|max:255',
            'tiktok_link' => 'nullable|url|max:255',
        ]);

        $validated['notify_admin_new_order'] = $request->boolean('notify_admin_new_order');
        $validated['notify_admin_new_user'] = $request->boolean('notify_admin_new_user');
        $validated['notify_admin_contact'] = $request->boolean('notify_admin_contact');

        $settings->fill($validated);
        $settings->save();

        $this->activityLogger->log(
            ActivityLog::LOG_SETTINGS,
            'updated',
            'Site settings updated',
            $settings,
            properties: array_keys($validated)
        );

        return redirect()->route('admin.settings.index')
            ->with('success', 'Site settings updated successfully.');
    }
}