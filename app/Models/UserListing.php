<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'listing_type',
        'title_deed',
        'oqood',
        'emirates_id',
        'property_status',
        'rent_frequency',
        'custom_rent_range',
        'price',
        'images',
        'status',
        'property_url',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
