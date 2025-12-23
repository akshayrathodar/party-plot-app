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
        Schema::create('seo_link_templates', function (Blueprint $table) {
            $table->id();
            
            // Template Name
            $table->string('name'); // e.g., "City Links Template"
            
            // Template Type
            $table->enum('template_type', ['city', 'area', 'category', 'city_category', 'area_category'])->default('city');
            
            // Templates with placeholders: {city}, {area}, {category}, {count}, {city_slug}, {area_slug}, {category_slug}
            $table->string('link_text_template'); // e.g., "Party Plots in {city}"
            $table->string('slug_template'); // e.g., "party-plots-in-{city_slug}"
            $table->string('meta_title_template'); // e.g., "Best Party Plots in {city} | PartyPlots"
            $table->text('meta_description_template')->nullable();
            $table->string('meta_keywords_template')->nullable();
            $table->string('page_title_template')->nullable(); // H1 template
            $table->text('page_description_template')->nullable();
            
            // Settings
            $table->boolean('is_active')->default(true);
            $table->integer('min_venues')->default(1); // Minimum venues required to generate link
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_link_templates');
    }
};






