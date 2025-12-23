<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('seo_links', function (Blueprint $table) {
            // Add tags field
            $table->string('tags')->nullable()->after('category_id');
            
            // Update enum to include tag-based types
            // Note: We need to modify the enum using raw SQL as Laravel doesn't support enum modification directly
        });

        // Update enum to include tag types using raw SQL
        DB::statement("ALTER TABLE seo_links MODIFY COLUMN link_type ENUM('city', 'area', 'category', 'city_category', 'area_category', 'tags', 'city_tags', 'area_tags', 'category_tags') DEFAULT 'city'");
        
        // Add index for tags
        Schema::table('seo_links', function (Blueprint $table) {
            $table->index('tags');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_links', function (Blueprint $table) {
            $table->dropIndex(['tags']);
            $table->dropColumn('tags');
        });

        // Revert enum to original
        DB::statement("ALTER TABLE seo_links MODIFY COLUMN link_type ENUM('city', 'area', 'category', 'city_category', 'area_category') DEFAULT 'city'");
    }
};
