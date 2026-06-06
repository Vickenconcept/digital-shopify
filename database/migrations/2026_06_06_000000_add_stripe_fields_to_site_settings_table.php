<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->text('stripe_key')->nullable()->after('tax_rate');
            $table->text('stripe_secret')->nullable()->after('stripe_key');
            $table->text('stripe_webhook_secret')->nullable()->after('stripe_secret');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['stripe_key', 'stripe_secret', 'stripe_webhook_secret']);
        });
    }
};
