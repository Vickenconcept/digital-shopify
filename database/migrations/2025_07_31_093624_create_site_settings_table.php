<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            
            // Weekly Theme and Focus
            $table->string('weekly_theme_title')->nullable();
            $table->text('weekly_theme_description')->nullable();
            $table->date('weekly_theme_start_date')->nullable();
            
            // Daily Messages
            $table->text('monday_message')->nullable();
            $table->text('tuesday_message')->nullable();
            $table->text('wednesday_message')->nullable();
            $table->text('thursday_message')->nullable();
            $table->text('friday_message')->nullable();
            $table->text('saturday_message')->nullable();
            $table->text('sunday_message')->nullable();
            
            // Call to Action
            $table->string('cta_title')->nullable();
            $table->string('cta_button_text')->nullable();
            
            // Social Media Links
            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('tiktok_link')->nullable();
            
            // Hero Images
            $table->string('hero_image_1')->nullable();
            $table->string('hero_image_2')->nullable();
            $table->string('hero_image_3')->nullable();
            
            // Banner Images
            $table->string('banner_image_1')->nullable();
            $table->string('banner_image_2')->nullable();
            $table->string('banner_image_3')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};