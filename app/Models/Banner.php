<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'heading',
        'sub_heading',
        'cta_text',
        'cta_url',
        'image',
        'image_display',
        'text_placement',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'image_display' => 'array',
    ];

    /**
     * Full URL for the banner image (works for files in public/storage/banners/).
     */
    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image)) {
            return null;
        }
        $path = $this->image;
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }
        return asset('storage/' . $path);
    }

    /**
     * CSS style string for background-size, background-position from image_display (crop, zoom, position).
     */
    public function getImageDisplayStyleAttribute(): string
    {
        $d = $this->image_display;
        if (empty($d) || ! is_array($d)) {
            return 'background-size: cover; background-position: center;';
        }
        $crop = $d['crop'] ?? null;
        if (! empty($crop) && isset($crop['w'], $crop['h']) && (float) $crop['w'] > 0 && (float) $crop['h'] > 0) {
            $x = (float) ($crop['x'] ?? 0);
            $y = (float) ($crop['y'] ?? 0);
            $w = (float) $crop['w'];
            $h = (float) $crop['h'];
            $w = max(1, min(100, $w));
            $h = max(1, min(100, $h));
            $sizeW = round(100 / $w * 100) . '%';
            $sizeH = round(100 / $h * 100) . '%';
            $posX = round($x + $w / 2, 2) . '%';
            $posY = round($y + $h / 2, 2) . '%';
            return sprintf('background-size: %s %s; background-position: %s %s;', $sizeW, $sizeH, $posX, $posY);
        }
        $zoom = isset($d['zoom']) ? (float) $d['zoom'] : 1;
        $zoom = max(0.5, min(3, $zoom));
        $posX = $d['position_x'] ?? 'center';
        $posY = $d['position_y'] ?? 'center';
        if (is_numeric($posX)) {
            $posX = max(0, min(100, (float) $posX)) . '%';
        }
        if (is_numeric($posY)) {
            $posY = max(0, min(100, (float) $posY)) . '%';
        }
        $size = round(100 * $zoom) . '%';
        return sprintf('background-size: %1$s; background-position: %2$s %3$s;', $size, $posX, $posY);
    }
}
