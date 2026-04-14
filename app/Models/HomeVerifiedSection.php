<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeVerifiedSection extends Model
{
    protected $fillable = [
        'heading',
        'intro_text',
        'cards',
        'item_1_title',
        'item_1_description',
        'item_2_title',
        'item_2_description',
        'item_3_title',
        'item_3_description',
        'item_4_title',
        'item_4_description',
        'footer_text',
        'heading_color',
        'text_color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'cards' => 'array',
    ];
}
