<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

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
            'cta_button_text' => 'nullable|string|max:255',
            'facebook_link' => 'nullable|url|max:255',
            'twitter_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url|max:255',
            'youtube_link' => 'nullable|url|max:255',
            'tiktok_link' => 'nullable|url|max:255',
            'hero_image_1' => 'nullable|image|max:2048|mimes:png,jpg,jpeg,gif,webp,svg,psd',
            'hero_image_2' => 'nullable|image|max:2048|mimes:png,jpg,jpeg,gif,webp,svg,psd',
            'hero_image_3' => 'nullable|image|max:2048|mimes:png,jpg,jpeg,gif,webp,svg,psd',
            'banner_image_1' => 'nullable|image|max:2048|mimes:png,jpg,jpeg,gif,webp,svg,psd',
            'banner_image_2' => 'nullable|image|max:2048|mimes:png,jpg,jpeg,gif,webp,svg,psd',
            'banner_image_3' => 'nullable|image|max:2048|mimes:png,jpg,jpeg,gif,webp,svg,psd',
        ]);

        // Handle text inputs
        $settings->fill($request->except([
            'hero_image_1', 'hero_image_2', 'hero_image_3',
            'banner_image_1', 'banner_image_2', 'banner_image_3'
        ]));

        // Handle hero images
        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("hero_image_$i")) {
                $settings->{"hero_image_$i"} = $this->fileUploadService->uploadFile($request->file("hero_image_$i"), 'settings/hero');
            }
        }

        // Handle banner images
        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("banner_image_$i")) {
                $settings->{"banner_image_$i"} = $this->fileUploadService->uploadFile($request->file("banner_image_$i"), 'settings/banners');
            }
        }

        $settings->save();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Site settings updated successfully.');
    }
}