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
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Hero Section
            $table->string('title')->nullable();
            $table->string('hero_image')->nullable();

            // Process Section
            $table->string('process_title')->nullable();
            $table->text('process_description')->nullable();
            $table->json('process_steps')->nullable();

            // Gallery Section
            $table->string('gallery_title')->nullable();
            $table->text('gallery_description')->nullable();
            $table->json('gallery_images')->nullable();

            // SEO Content (Long Text)
            $table->longText('seo_content')->nullable();

            // Status
            $table->boolean('status')->default(true);

            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
