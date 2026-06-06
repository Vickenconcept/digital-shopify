<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('body_html')->nullable();
            $table->longText('body_css')->nullable();
            $table->longText('custom_js')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('show_in_navigation')->default(false);
            $table->boolean('show_in_footer')->default(false);
            $table->boolean('is_system')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
