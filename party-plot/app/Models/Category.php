<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            // Auto-generate slug if not provided
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);

                // Ensure uniqueness
                $originalSlug = $category->slug;
                $count = 1;
                while (static::where('slug', $category->slug)->exists()) {
                    $category->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });

        static::updating(function ($category) {
            // Auto-generate slug if name changed and slug is empty
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);

                // Ensure uniqueness
                $originalSlug = $category->slug;
                $count = 1;
                while (static::where('slug', $category->slug)->where('id', '!=', $category->id)->exists()) {
                    $category->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
    }

    /**
     * Get active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get categories ordered by sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }

    /**
     * Relationship: Party plots in this category
     */
    public function partyPlots()
    {
        return $this->hasMany(PartyPlot::class, 'category_id');
    }

    /**
     * Get category name with count
     */
    public function getNameWithCountAttribute()
    {
        $count = $this->partyPlots()->count();
        return "{$this->name} ({$count})";
    }
}









