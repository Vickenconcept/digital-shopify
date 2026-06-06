<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('notify_admin_new_order')->default(true)->after('contact_address');
            $table->boolean('notify_admin_new_user')->default(true)->after('notify_admin_new_order');
            $table->boolean('notify_admin_contact')->default(true)->after('notify_admin_new_user');
            $table->unsignedSmallInteger('audit_log_retention_days')->default(90)->after('notify_admin_contact');
            $table->decimal('tax_rate', 5, 2)->default(0)->after('audit_log_retention_days');
        });

        Schema::table('digital_products', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('description');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('og_image')->nullable()->after('meta_description');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('excerpt');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('og_image')->nullable()->after('meta_description');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('title');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('og_image')->nullable()->after('meta_description');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'notify_admin_new_order',
                'notify_admin_new_user',
                'notify_admin_contact',
                'audit_log_retention_days',
                'tax_rate',
            ]);
        });

        Schema::table('digital_products', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description', 'og_image']);
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description', 'og_image']);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description', 'og_image']);
        });
    }
};
