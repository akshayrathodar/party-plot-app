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
            $table->string('area')->nullable()->after('city');
            $table->index('area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('party_plots', function (Blueprint $table) {
            $table->dropIndex(['area']);
            $table->dropColumn('area');
        });
    }
};

