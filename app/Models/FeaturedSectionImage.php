<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeaturedSectionImage extends Model
{
    protected $table = 'featured_section_images';

    protected $fillable = [
        'featured_section_id',
        'image_path',
        'heading',
        'second_heading',
        'heading_order',
        'cta_url',
        'background_color',
        'sort_order',
    ];

    public function featuredSection(): BelongsTo
    {
        return $this->belongsTo(FeaturedSection::class);
    }
}
