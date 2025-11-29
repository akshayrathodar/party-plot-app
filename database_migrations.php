<?php
// Database Migrations for Party Plot Listing Platform

// ============================================
// 1. Categories Migration
// ============================================
Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->string('icon')->nullable();
    $table->string('image')->nullable();
    $table->boolean('is_active')->default(true);
    $table->integer('sort_order')->default(0);
    $table->string('meta_title')->nullable();
    $table->text('meta_description')->nullable();
    $table->timestamps();
});

// ============================================
// 2. Tags Migration
// ============================================
Schema::create('tags', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->enum('type', ['location', 'amenity', 'feature'])->default('location');
    $table->text('description')->nullable();
    $table->boolean('is_active')->default(true);
    $table->string('meta_title')->nullable();
    $table->text('meta_description')->nullable();
    $table->text('meta_keywords')->nullable();
    $table->timestamps();
});

// ============================================
// 3. Party Plots Migration
// ============================================
Schema::create('party_plots', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('category_id')->constrained()->onDelete('restrict');
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('short_description');
    $table->text('full_description');
    $table->string('address');
    $table->string('city');
    $table->string('state');
    $table->string('pincode');
    $table->decimal('latitude', 10, 8)->nullable();
    $table->decimal('longitude', 11, 8)->nullable();
    $table->string('contact_phone');
    $table->string('contact_email')->nullable();
    $table->string('contact_name')->nullable();
    $table->boolean('show_contact')->default(false);
    $table->integer('capacity_min')->nullable();
    $table->integer('capacity_max')->nullable();
    $table->decimal('price_starting_from', 10, 2)->nullable();
    $table->decimal('price_per_person', 10, 2)->nullable();
    $table->json('amenities')->nullable();
    $table->boolean('featured')->default(false);
    $table->boolean('is_active')->default(true);
    $table->boolean('is_approved')->default(false);
    $table->integer('views_count')->default(0);
    $table->integer('leads_count')->default(0);
    $table->decimal('rating_average', 3, 2)->nullable();
    $table->integer('rating_count')->default(0);
    $table->string('meta_title')->nullable();
    $table->text('meta_description')->nullable();
    $table->text('meta_keywords')->nullable();
    $table->timestamps();
    
    $table->index('slug');
    $table->index('is_active');
    $table->index('is_approved');
    $table->index('featured');
});

// ============================================
// 4. Party Plot Images Migration
// ============================================
Schema::create('party_plot_images', function (Blueprint $table) {
    $table->id();
    $table->foreignId('party_plot_id')->constrained()->onDelete('cascade');
    $table->string('image_path');
    $table->enum('image_type', ['gallery', 'thumbnail', 'featured'])->default('gallery');
    $table->string('alt_text')->nullable();
    $table->integer('sort_order')->default(0);
    $table->boolean('is_primary')->default(false);
    $table->timestamps();
    
    $table->index('party_plot_id');
});

// ============================================
// 5. Party Plot Tags (Pivot) Migration
// ============================================
Schema::create('party_plot_tags', function (Blueprint $table) {
    $table->id();
    $table->foreignId('party_plot_id')->constrained()->onDelete('cascade');
    $table->foreignId('tag_id')->constrained()->onDelete('cascade');
    $table->timestamps();
    
    $table->unique(['party_plot_id', 'tag_id']);
    $table->index('tag_id');
});

// ============================================
// 6. Leads Migration
// ============================================
Schema::create('leads', function (Blueprint $table) {
    $table->id();
    $table->foreignId('party_plot_id')->constrained()->onDelete('cascade');
    $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
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

// ============================================
// 7. Lead Purchases Migration
// ============================================
Schema::create('lead_purchases', function (Blueprint $table) {
    $table->id();
    $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('lead_id')->constrained()->onDelete('cascade');
    $table->decimal('purchase_price', 10, 2);
    $table->timestamp('purchased_at');
    $table->enum('status', ['pending', 'completed', 'refunded'])->default('pending');
    $table->timestamps();
    
    $table->index('vendor_id');
    $table->index('lead_id');
});

// ============================================
// 8. SEO Pages Migration
// ============================================
Schema::create('seo_pages', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tag_id')->nullable()->constrained()->onDelete('cascade');
    $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
    $table->enum('page_type', ['tag', 'category', 'location'])->default('tag');
    $table->string('slug')->unique();
    $table->string('title');
    $table->string('meta_title');
    $table->text('meta_description');
    $table->text('meta_keywords')->nullable();
    $table->text('content')->nullable();
    $table->boolean('is_active')->default(true);
    $table->integer('views_count')->default(0);
    $table->timestamps();
    
    $table->index('slug');
    $table->index('page_type');
});

// ============================================
// 9. Analytics Migration
// ============================================
Schema::create('analytics', function (Blueprint $table) {
    $table->id();
    $table->enum('event_type', ['view', 'lead', 'click', 'search']);
    $table->foreignId('party_plot_id')->nullable()->constrained()->onDelete('set null');
    $table->foreignId('tag_id')->nullable()->constrained()->onDelete('set null');
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
    $table->string('ip_address', 45)->nullable();
    $table->text('user_agent')->nullable();
    $table->string('referrer')->nullable();
    $table->timestamps();
    
    $table->index('event_type');
    $table->index('party_plot_id');
    $table->index('created_at');
});

// ============================================
// 10. Users Table Extension (Add to existing users migration)
// ============================================
Schema::table('users', function (Blueprint $table) {
    $table->string('phone')->nullable()->after('email');
    $table->enum('user_type', ['admin', 'vendor', 'user'])->default('user')->after('phone');
    $table->enum('vendor_status', ['pending', 'approved', 'rejected'])->nullable()->after('user_type');
    $table->string('vendor_company_name')->nullable()->after('vendor_status');
    $table->text('vendor_address')->nullable();
    $table->string('vendor_gst_number')->nullable();
    $table->boolean('is_active')->default(true)->after('vendor_gst_number');
    
    $table->index('user_type');
    $table->index('vendor_status');
});

