<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeaturedSectionDeveloper extends Model
{
    protected $table = 'featured_section_developers';

    protected $fillable = [
        'featured_section_id',
        'name',
        'logo_text',
        'logo_dark',
        'search_slug',
        'sort_order',
    ];

    protected $casts = [
        'logo_dark' => 'boolean',
    ];

    public function featuredSection(): BelongsTo
    {
        return $this->belongsTo(FeaturedSection::class);
    }

    public function getLogoTextDisplayAttribute(): string
    {
        return $this->logo_text ?: strtoupper(explode(' ', trim($this->name))[0] ?? '');
    }
}
