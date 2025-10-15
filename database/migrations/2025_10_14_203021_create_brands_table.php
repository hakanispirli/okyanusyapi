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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();

            // Section Information
            $table->string('name'); // Section title
            $table->text('description')->nullable(); // Section description

            // Brand Images (JSON array like gallery_images in services)
            $table->json('brands_images')->nullable();

            // Display Settings
            $table->boolean('status')->default(true);

            $table->timestamps();

            // Indexes
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
