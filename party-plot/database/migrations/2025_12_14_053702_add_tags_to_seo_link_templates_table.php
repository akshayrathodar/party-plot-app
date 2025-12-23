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
        // Update enum to include tag types using raw SQL
        DB::statement("ALTER TABLE seo_link_templates MODIFY COLUMN template_type ENUM('city', 'area', 'category', 'city_category', 'area_category', 'tags', 'city_tags', 'area_tags', 'category_tags') DEFAULT 'city'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert enum to original
        DB::statement("ALTER TABLE seo_link_templates MODIFY COLUMN template_type ENUM('city', 'area', 'category', 'city_category', 'area_category') DEFAULT 'city'");
    }
};





