<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Property;


class PropertyPicture extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id', 'path',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
