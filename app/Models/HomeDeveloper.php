<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeDeveloper extends Model
{
    protected $table = 'home_developers';

    protected $fillable = [
        'name',
        'logo_text',
        'logo_dark',
        'search_slug',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'logo_dark' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Logo text for the card (short label). Falls back to first word of name.
     */
    public function getLogoTextDisplayAttribute(): string
    {
        return $this->logo_text ?: strtoupper(explode(' ', trim($this->name))[0] ?? '');
    }
}
