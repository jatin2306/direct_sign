<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeaturedSection extends Model
{
    protected $fillable = [
        'type',
        'title',
        'heading',
        'heading_placement',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'featured_section_property')
            ->withPivot('sort_order')
            ->orderByPivot('sort_order')
            ->withTimestamps();
    }

    public function developers(): HasMany
    {
        return $this->hasMany(FeaturedSectionDeveloper::class)->orderBy('sort_order');
    }

    public function images(): HasMany
    {
        return $this->hasMany(FeaturedSectionImage::class)->orderBy('sort_order');
    }

    public function isPropertiesType(): bool
    {
        return ($this->type ?? 'properties') === 'properties';
    }

    public function isDevelopersType(): bool
    {
        return ($this->type ?? 'properties') === 'developers';
    }

    public function isImageCarouselType(): bool
    {
        return ($this->type ?? 'properties') === 'image_carousel';
    }
}
