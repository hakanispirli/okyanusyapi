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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable(); // Short description for listing
            $table->longText('content'); // Main blog content

            // Category Relationship
            $table->foreignId('category_id')->constrained('blog_categories')->onDelete('cascade');

            // Author Information
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');

            // Hero Section
            $table->string('featured_image')->nullable();
            $table->string('featured_image_alt')->nullable();

            // Gallery Section (for multiple images)
            $table->json('gallery_images')->nullable();

            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->json('meta_og')->nullable(); // Open Graph data

            // Reading & Engagement
            $table->integer('reading_time')->nullable(); // Estimated reading time in minutes
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);

            // Publishing
            $table->boolean('status')->default(false); // Draft/Published
            $table->boolean('featured')->default(false); // Featured post
            $table->timestamp('published_at')->nullable();

            // Tags (stored as JSON array)
            $table->json('tags')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('slug');
            $table->index('category_id');
            $table->index('author_id');
            $table->index('featured');
            $table->index('published_at');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
