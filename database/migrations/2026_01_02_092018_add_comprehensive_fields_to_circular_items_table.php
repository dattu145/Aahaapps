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
        Schema::table('circular_items', function (Blueprint $table) {
            // Section 1: Top Thumbnails
            $table->json('section1_images')->nullable(); // Array of image URLs/paths
            $table->integer('section1_image_width')->nullable();
            $table->integer('section1_image_height')->nullable();
            
            // Section 2: Main Content Image
            $table->string('section2_image')->nullable();
            
            // Section 3: Dynamic Buttons (JSON array of objects with text, bg_color, text_color, link)
            $table->json('buttons')->nullable();
            $table->string('enquiry_link')->nullable(); // Dedicated enquiry button link
            
            // Card-specific color overrides (override global settings)
            $table->string('card_bg_color')->nullable();
            $table->string('title_color')->nullable();
            $table->string('desc_color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('circular_items', function (Blueprint $table) {
            $table->dropColumn([
                'section1_images',
                'section1_image_width',
                'section1_image_height',
                'section2_image',
                'buttons',
                'enquiry_link',
                'card_bg_color',
                'title_color',
                'desc_color'
            ]);
        });
    }
};
