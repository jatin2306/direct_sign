<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeWhySection extends Model
{
    protected $fillable = [
        'heading',
        'background_color',
        'heading_color',
        'cards',
        'is_active',
    ];

    protected $casts = [
        'cards' => 'array',
        'is_active' => 'boolean',
    ];
}
