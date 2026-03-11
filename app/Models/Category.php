<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ChildType;

class Category extends Model
{
    protected $fillable = ['name'];

    // A category has many child types
    public function childType()
    {
        return $this->hasMany(ChildType::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'property_category_id');
    }
}
