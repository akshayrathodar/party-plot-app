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
        Schema::table('party_plots', function (Blueprint $table) {
            $table->integer('visitors')->default(0)->after('google_review_text');
            $table->index('visitors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('party_plots', function (Blueprint $table) {
            $table->dropIndex(['visitors']);
            $table->dropColumn('visitors');
        });
    }
};

