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
        Schema::create('seo_links', function (Blueprint $table) {
            $table->id();
            
            // Link Type
            $table->enum('link_type', ['city', 'area', 'category', 'city_category', 'area_category'])->default('city');
            
            // Filter Values
            $table->string('city')->nullable();
            $table->string('area')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            
            // Display Text
            $table->string('link_text'); // e.g., "Party Plots in Ahmedabad"
            $table->string('slug')->unique(); // e.g., "party-plots-in-ahmedabad"
            
            // SEO Meta Tags
            $table->string('meta_title');
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            // Page Content
            $table->string('page_title')->nullable(); // H1 heading
            $table->text('page_description')->nullable(); // Intro paragraph
            
            // Settings
            $table->boolean('is_active')->default(true);
            $table->boolean('show_on_homepage')->default(true);
            $table->integer('sort_order')->default(0);
            
            // Template reference (if generated from template)
            $table->unsignedBigInteger('template_id')->nullable();
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('template_id')->references('id')->on('seo_link_templates')->onDelete('set null');
            
            // Indexes for faster queries
            $table->index('link_type');
            $table->index('city');
            $table->index('area');
            $table->index('is_active');
            $table->index('show_on_homepage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_links');
    }
};






