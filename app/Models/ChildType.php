<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class ChildType extends Model
{
    protected $fillable = ['name', 'category_id'];

    // A child type belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // A child type can have many properties
    public function properties()
    {
        return $this->hasMany(Property::class, 'child_type_id');
    }
}
