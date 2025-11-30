<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PartyPlot extends Model
{
    use HasFactory;

    protected $fillable = [
        // Required
        'name',
        'description',
        'full_address',
        'city',
        'area',
        'latitude',
        'longitude',
        'slug',
        'creator_user_id',
        'category_id',
        'place_id',

        // Optional Venue Details
        'capacity_min',
        'capacity_max',
        'price_range_min',
        'price_range_max',
        'area_lawn',
        'area_banquet',
        'suitable_events',
        'tags',

        // Optional Amenities
        'parking',
        'rooms',
        'dj_allowed',
        'decoration_allowed',
        'catering_allowed',
        'generator_backup',
        'ac_available',

        // Optional Media
        'featured_image',
        'gallery_images',
        'video_links',

        // Optional Ratings
        'google_rating',
        'google_review_count',
        'google_review_text',
        'visitors',

        // Optional Social
        'instagram',
        'facebook',
        'twitter',
        'youtube',
        'website',
        'email',
        'phone',

        // System
        'status',
        'listing_status',
        'verified',
        'claimed_by_user_id',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'price_range_min' => 'decimal:2',
        'price_range_max' => 'decimal:2',
        'google_rating' => 'decimal:2',
        'parking' => 'boolean',
        'rooms' => 'boolean',
        'dj_allowed' => 'boolean',
        'decoration_allowed' => 'boolean',
        'catering_allowed' => 'boolean',
        'generator_backup' => 'boolean',
        'ac_available' => 'boolean',
        'verified' => 'boolean',
        'gallery_images' => 'array',
        'video_links' => 'array',
        'tags' => 'array',
        'capacity_min' => 'integer',
        'capacity_max' => 'integer',
        'google_review_count' => 'integer',
        'visitors' => 'integer',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($partyPlot) {
            // Auto-generate slug if not provided
            if (empty($partyPlot->slug)) {
                $partyPlot->slug = Str::slug($partyPlot->name);

                // Ensure uniqueness
                $originalSlug = $partyPlot->slug;
                $count = 1;
                while (static::where('slug', $partyPlot->slug)->exists()) {
                    $partyPlot->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
    }

    /**
     * Get the creator user
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_user_id');
    }

    /**
     * Get the claimed user (vendor)
     */
    public function claimedBy()
    {
        return $this->belongsTo(User::class, 'claimed_by_user_id');
    }

    /**
     * Get the category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope for active plots
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for approved plots
     */
    public function scopeApproved($query)
    {
        return $query->where('listing_status', 'approved');
    }

    /**
     * Get suitable events as array
     */
    public function getSuitableEventsArrayAttribute()
    {
        if (empty($this->suitable_events)) {
            return [];
        }

        // Try JSON first, then comma-separated
        $decoded = json_decode($this->suitable_events, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }

        return array_filter(array_map('trim', explode(',', $this->suitable_events)));
    }

    /**
     * Set suitable events
     */
    public function setSuitableEventsAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['suitable_events'] = json_encode($value);
        } else {
            $this->attributes['suitable_events'] = $value;
        }
    }
}

