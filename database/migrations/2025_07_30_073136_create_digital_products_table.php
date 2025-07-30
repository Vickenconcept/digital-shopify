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
        Schema::create('digital_products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author')->nullable();
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 10, 2)->nullable();
            $table->string('file_path');
            $table->string('original_filename')->nullable();
            $table->string('file_type'); // audio, video, ebook, etc.
            $table->string('thumbnail_path')->nullable();
            $table->string('preview_path')->nullable(); // For sample/preview content
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Creator/uploader
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_free')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('published_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_products');
    }
};
