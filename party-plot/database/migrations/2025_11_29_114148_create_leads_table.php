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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('party_plot_id')->constrained('party_plots')->onDelete('cascade');
            $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->date('function_date');
            $table->text('message')->nullable();
            $table->enum('status', ['new', 'contacted', 'converted', 'lost'])->default('new');
            $table->enum('source', ['free', 'purchased'])->default('free');
            $table->decimal('lead_price', 10, 2)->nullable();
            $table->timestamp('purchased_at')->nullable();
            $table->text('vendor_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            
            $table->index('party_plot_id');
            $table->index('vendor_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
