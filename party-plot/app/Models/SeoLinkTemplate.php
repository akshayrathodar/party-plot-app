<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoLinkTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'template_type',
        'link_text_template',
        'slug_template',
        'meta_title_template',
        'meta_description_template',
        'meta_keywords_template',
        'page_title_template',
        'page_description_template',
        'is_active',
        'min_venues',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'min_venues' => 'integer',
    ];

    /**
     * Available placeholders for templates
     */
    public static function getPlaceholders(): array
    {
        return [
            '{city}' => 'City name (e.g., Ahmedabad)',
            '{area}' => 'Area name (e.g., Satellite)',
            '{category}' => 'Category name (e.g., Party Plots)',
            '{tags}' => 'Tags (e.g., wedding, outdoor, pool)',
            '{city_slug}' => 'City slug (e.g., ahmedabad)',
            '{area_slug}' => 'Area slug (e.g., satellite)',
            '{category_slug}' => 'Category slug (e.g., party-plots)',
            '{tags_slug}' => 'Tags slug (e.g., wedding-outdoor-pool)',
            '{count}' => 'Number of venues matching criteria',
        ];
    }

    /**
     * Get SEO links generated from this template
     */
    public function seoLinks()
    {
        return $this->hasMany(SeoLink::class, 'template_id');
    }

    /**
     * Scope for active templates
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get template type label
     */
    public function getTypeLabelAttribute(): string
    {
        $labels = [
            'city' => 'City Only',
            'area' => 'Area Only',
            'category' => 'Category Only',
            'city_category' => 'City + Category',
            'area_category' => 'Area + Category',
            'tags' => 'Tags Only',
            'city_tags' => 'City + Tags',
            'area_tags' => 'Area + Tags',
            'category_tags' => 'Category + Tags',
        ];

        return $labels[$this->template_type] ?? $this->template_type;
    }
}


