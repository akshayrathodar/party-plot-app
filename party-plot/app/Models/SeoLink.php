<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SeoLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_type',
        'city',
        'area',
        'category_id',
        'tags',
        'link_text',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'page_title',
        'page_description',
        'is_active',
        'show_on_homepage',
        'sort_order',
        'template_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_on_homepage' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($seoLink) {
            // Auto-generate slug if not provided
            if (empty($seoLink->slug)) {
                $seoLink->slug = Str::slug($seoLink->link_text);

                // Ensure uniqueness
                $originalSlug = $seoLink->slug;
                $count = 1;
                while (static::where('slug', $seoLink->slug)->exists()) {
                    $seoLink->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }

            // Set page_title from link_text if not provided
            if (empty($seoLink->page_title)) {
                $seoLink->page_title = $seoLink->link_text;
            }
        });
    }

    /**
     * Get the category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the template used to generate this link
     */
    public function template()
    {
        return $this->belongsTo(SeoLinkTemplate::class, 'template_id');
    }

    /**
     * Scope for active links
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for homepage links
     */
    public function scopeHomepage($query)
    {
        return $query->where('show_on_homepage', true);
    }

    /**
     * Scope ordered by sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('link_text', 'asc');
    }

    /**
     * Get link type label
     */
    public function getTypeLabelAttribute(): string
    {
        $labels = [
            'city' => 'City',
            'area' => 'Area',
            'category' => 'Category',
            'city_category' => 'City + Category',
            'area_category' => 'Area + Category',
            'tags' => 'Tags',
            'city_tags' => 'City + Tags',
            'area_tags' => 'Area + Tags',
            'category_tags' => 'Category + Tags',
        ];

        return $labels[$this->link_type] ?? $this->link_type;
    }

    /**
     * Get the full URL for this SEO link
     */
    public function getUrlAttribute(): string
    {
        return route('seo-link.show', $this->slug);
    }

    /**
     * Get venue count for this link's filter criteria
     */
    public function getVenueCountAttribute(): int
    {
        $query = PartyPlot::where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending']);

        if ($this->city) {
            $query->where('city', $this->city);
        }

        if ($this->area) {
            $query->where('area', $this->area);
        }

        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }

        if ($this->tags) {
            $tagsArray = is_array($this->tags) ? $this->tags : explode(',', $this->tags);
            $tagsArray = array_map('trim', $tagsArray);
            $query->where(function($q) use ($tagsArray) {
                foreach ($tagsArray as $tag) {
                    $q->orWhereJsonContains('tags', $tag);
                }
            });
        }

        return $query->count();
    }

    /**
     * Build query for fetching matching party plots
     */
    public function getPartyPlotsQuery()
    {
        $query = PartyPlot::with('category')
            ->where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending']);

        if ($this->city) {
            $query->where('city', $this->city);
        }

        if ($this->area) {
            $query->where('area', $this->area);
        }

        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }

        if ($this->tags) {
            $tagsArray = is_array($this->tags) ? $this->tags : explode(',', $this->tags);
            $tagsArray = array_map('trim', $tagsArray);
            $query->where(function($q) use ($tagsArray) {
                foreach ($tagsArray as $tag) {
                    $q->orWhereJsonContains('tags', $tag);
                }
            });
        }

        // Order by images first, then by created_at
        $query->orderByRaw('CASE WHEN featured_image IS NOT NULL AND featured_image != "" AND featured_image != "null" THEN 0 ELSE 1 END')
              ->orderBy('created_at', 'desc');

        return $query;
    }
}


