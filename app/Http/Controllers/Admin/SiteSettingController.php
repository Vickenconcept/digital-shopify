<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::firstOrCreate([]);
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = SiteSetting::firstOrCreate([]);
        
        $validated = $request->validate([
            'weekly_theme_title' => 'nullable|string|max:255',
            'weekly_theme_description' => 'nullable|string',
            'weekly_theme_start_date' => 'nullable|date',
            'monday_message' => 'nullable|string',
            'tuesday_message' => 'nullable|string',
            'wednesday_message' => 'nullable|string',
            'thursday_message' => 'nullable|string',
            'friday_message' => 'nullable|string',
            'saturday_message' => 'nullable|string',
            'sunday_message' => 'nullable|string',
            'cta_title' => 'nullable|string|max:255',
            'cta_description' => 'nullable|string',
            'cta_button_text' => 'nullable|string|max:255',
            'cta_button_link' => 'nullable|string|max:255',
            'facebook_link' => 'nullable|url|max:255',
            'twitter_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url|max:255',
            'youtube_link' => 'nullable|url|max:255',
            'tiktok_link' => 'nullable|url|max:255',
            'hero_image_1' => 'nullable|image|max:2048',
            'hero_image_2' => 'nullable|image|max:2048',
            'hero_image_3' => 'nullable|image|max:2048',
            'banner_image_1' => 'nullable|image|max:2048',
            'banner_image_2' => 'nullable|image|max:2048',
            'banner_image_3' => 'nullable|image|max:2048',
        ]);

        // Handle text inputs
        $settings->fill($request->except([
            'hero_image_1', 'hero_image_2', 'hero_image_3',
            'banner_image_1', 'banner_image_2', 'banner_image_3'
        ]));

        // Handle hero images
        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("hero_image_$i")) {
                if ($settings->{"hero_image_$i"}) {
                    Storage::disk('public')->delete($settings->{"hero_image_$i"});
                }
                $settings->{"hero_image_$i"} = $request->file("hero_image_$i")->store('settings/hero', 'public');
            }
        }

        // Handle banner images
        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("banner_image_$i")) {
                if ($settings->{"banner_image_$i"}) {
                    Storage::disk('public')->delete($settings->{"banner_image_$i"});
                }
                $settings->{"banner_image_$i"} = $request->file("banner_image_$i")->store('settings/banners', 'public');
            }
        }

        $settings->save();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Site settings updated successfully.');
    }
}