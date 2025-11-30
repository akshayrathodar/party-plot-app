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
        Schema::create('party_plots', function (Blueprint $table) {
            $table->id();
            
            // Required Fields
            $table->string('name');
            $table->text('full_address');
            $table->string('city');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('slug')->unique();
            $table->foreignId('creator_user_id')->constrained('users')->onDelete('cascade');
            
            // Optional Venue Details
            $table->integer('capacity_min')->nullable();
            $table->integer('capacity_max')->nullable();
            $table->decimal('price_range_min', 10, 2)->nullable();
            $table->decimal('price_range_max', 10, 2)->nullable();
            $table->string('area_lawn')->nullable();
            $table->string('area_banquet')->nullable();
            $table->text('suitable_events')->nullable(); // Will store as JSON or comma-separated
            
            // Optional Amenities (Boolean)
            $table->boolean('parking')->default(false);
            $table->boolean('rooms')->default(false);
            $table->boolean('dj_allowed')->default(false);
            $table->boolean('decoration_allowed')->default(false);
            $table->boolean('catering_allowed')->default(false);
            $table->boolean('generator_backup')->default(false);
            $table->boolean('ac_available')->default(false);
            
            // Optional Media
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->json('video_links')->nullable();
            
            // Optional Ratings
            $table->decimal('google_rating', 3, 2)->nullable();
            $table->integer('google_review_count')->nullable();
            $table->text('google_review_text')->nullable();
            
            // Optional Social
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            
            // System Fields
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('listing_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('verified')->default(false);
            $table->foreignId('claimed_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Place ID for CSV matching (optional)
            $table->string('place_id')->nullable()->unique();
            
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index('status');
            $table->index('listing_status');
            $table->index('city');
            $table->index('creator_user_id');
            $table->index('claimed_by_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('party_plots');
    }
};

