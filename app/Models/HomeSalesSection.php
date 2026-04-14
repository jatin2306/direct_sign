<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSalesSection extends Model
{
    protected $fillable = [
        'heading',
        'heading_highlight',
        'section_background_color',
        'heading_color',
        'heading_highlight_color',
        'box_background_color',
        'box_border_color',
        'step_title_color',
        'steps',
        'bottom_note',
        'bottom_note_prefix',
        'bottom_note_highlight',
        'bottom_note_suffix',
        'bottom_note_text_color',
        'bottom_note_highlight_color',
        'bottom_note_subtext',
        'is_active',
    ];

    protected $casts = [
        'steps' => 'array',
        'is_active' => 'boolean',
    ];
}
