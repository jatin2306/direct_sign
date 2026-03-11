<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\PropertyPicture;
use App\Models\Category;
use App\Models\ChildType;
use App\Models\User;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'created_by_admin_id',
        'propertyType',
        'property_category_id',
        'child_type_id',
        'propertyName',
        'address',
        'latitude',
        'longitude',
        'bedrooms',
        'bathrooms',
        'builtArea',
        'plotArea',
        'unitNo',
        'floorNo',
        'furnished',
        'balcony',
        'community',
        'view',
        'parking',
        'status',
        'any_upgrades',
        'communityFee',
        'mortgaged',
        'price',
        'amenities', // Ensure this is cast properly as JSON in the database.
        'city',
        'sub_area',
        'is_featured',
        'verified',
        'needs_photographer',
        'description',
        'reference',
        'broker_license',
        'zone_name',
        'dld_permit_number',
        'agent_license',
        'regulatory_image',
    ];
    

    protected $casts = [
        'amenities' => 'array',
    ];

    /**
     * SEO-friendly slug computed from existing fields (no DB column).
     * e.g. 2-bedroom-apartment-for-sale-dubai-marina-160
     */
    public function getSlugAttribute(): string
    {
        return $this->generateSlug();
    }

    /**
     * Generate SEO-friendly slug from existing columns.
     */
    public function generateSlug(): string
    {
        $bedrooms = $this->bedrooms;
        $bedPart = ($bedrooms === null || $bedrooms === '') ? 'studio' : $bedrooms . '-bedroom';
        $typePart = 'property';
        if ($this->relationLoaded('childTypeRelation') && $this->childTypeRelation) {
            $typePart = Str::slug($this->childTypeRelation->name);
        } elseif ($this->child_type_id) {
            $ct = ChildType::find($this->child_type_id);
            $typePart = $ct ? Str::slug($ct->name) : 'property';
        }
        $dealPart = $this->propertyType == '1' ? 'sale' : ($this->propertyType == '2' ? 'rent' : 'off-plan');
        $areaPart = Str::slug($this->sub_area ?: $this->city ?: 'dubai');
        return Str::slug($bedPart . '-' . $typePart . '-for-' . $dealPart . '-' . $areaPart) . '-' . $this->id;
    }
    
    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Relationship with Review model
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    // Relationship with PropertyPicture model
    public function pictures()
    {
        return $this->hasMany(PropertyPicture::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'property_category_id');
    }


    public function childTypeRelation()
    {
        return $this->belongsTo(ChildType::class, 'child_type_id');
    }

    // Accessor for average rating    
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating');
    }


    // Scope for property type
    public function scopeFilterByPropertyType($query, $propertyType)
    {
        if ($propertyType) {
            return $query->where('propertyType', $propertyType);
        }
        return $query;
    }

    // Scope for category
    public function scopeFilterByCategory($query, $category)
    {
        if ($category) {
            return $query->where('property_category_id', $category);
        }
        return $query;
    }

    // Scope for child type
    public function scopeFilterByChildType($query, $childType)
    {
        if ($childType) {
            return $query->where('child_type_id', $childType);
        }
        return $query;
    }

    public function scopeFilterByPrice($query, $priceMin, $priceMax)
    {
        if ($priceMin !== null && $priceMax !== null) {
            $min = (int) $priceMin;
            $max = (int) $priceMax;
            if ($min > $max) {
                [$min, $max] = [$max, $min];
            }
            $query->whereBetween('price', [$min, $max]);
            return $query;
        }
        if ($priceMin !== null && $priceMin !== '') {
            $query->where('price', '>=', (int) $priceMin);
        }
        if ($priceMax !== null && $priceMax !== '') {
            $query->where('price', '<=', (int) $priceMax);
        }
        return $query;
    }

    /** Filter by built area (sqft): min and/or max */
    public function scopeFilterByArea($query, $areaMin, $areaMax)
    {
        if ($areaMin !== null && $areaMin !== '' && $areaMax !== null && $areaMax !== '') {
            $min = (int) $areaMin;
            $max = (int) $areaMax;
            if ($min > $max) {
                [$min, $max] = [$max, $min];
            }
            $query->whereBetween('builtArea', [$min, $max]);
            return $query;
        }
        if ($areaMin !== null && $areaMin !== '') {
            $query->where('builtArea', '>=', (int) $areaMin);
        }
        if ($areaMax !== null && $areaMax !== '') {
            $query->where('builtArea', '<=', (int) $areaMax);
        }
        return $query;
    }


    // Scope for status
    public function scopeFilterByStatus($query, $status)
    {
        if (!is_null($status)) {
            return $query->where('status', $status);
        }
        return $query;
    }

    // Scope for verified (admin: Verified / Not Verified)
    public function scopeFilterByVerified($query, $verified)
    {
        if ($verified !== null && $verified !== '') {
            return $query->where('verified', (bool) (int) $verified);
        }
        return $query;
    }
    // Scope for Bedrooms Bathrooms and Location

    public function scopeFilterByBedrooms($query, $bedrooms)
    {
        if ($bedrooms !== null && $bedrooms !== '') {
            return $query->where('bedrooms', (int) $bedrooms);
        }
        return $query;
    }

    public function scopeFilterByBathrooms($query, $bathrooms)
    {
        if ($bathrooms !== null && $bathrooms !== '') {
            return $query->where('bathrooms', (int) $bathrooms);
        }
        return $query;
    }

    public function scopeFilterByLocation($query, $location)
    {
        if ($location) {
            return $query->where(function ($query) use ($location) {
                $query->where('city', 'LIKE', '%' . $location . '%')
                      ->orWhere('sub_area', 'LIKE', '%' . $location . '%');
            });
        }
        return $query;
    }
    // Scope for Verified properties
    public function scopeVerified($query)
    {
        return $query->where('verified', true);
    }

    public function isFavoritedBy($user)
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'property_user_subscriptions')
                    ->withPivot('notification_type')
                    ->withTimestamps();
    }

    /**
     * Admin panel: search across all relevant text/numeric fields (case-insensitive).
     */
    public function scopeAdminSearch($query, $term)
    {
        if ($term === null || $term === '') {
            return $query;
        }

        $term = trim($term);
        if ($term === '') {
            return $query;
        }

        $pattern = '%' . mb_strtolower($term) . '%';
        $termLower = mb_strtolower($term);

        return $query->where(function ($q) use ($term, $termLower, $pattern) {
            // Type: Buy / Rent / Off Plan
            if (str_contains($termLower, 'buy')) {
                $q->orWhere('propertyType', '1');
            }
            if (str_contains($termLower, 'rent')) {
                $q->orWhere('propertyType', '2');
            }
            if (str_contains($termLower, 'off plan') || str_contains($termLower, 'offplan')) {
                $q->orWhere('propertyType', '3');
            }
            // Status: Verified / Not verified
            if (str_contains($termLower, 'unverified') || (str_contains($termLower, 'not') && str_contains($termLower, 'verified'))) {
                $q->orWhere('verified', false);
            } elseif (str_contains($termLower, 'verified')) {
                $q->orWhere('verified', true);
            }
            // Case-insensitive text search (e.g. "marwa" matches "Marwa Homes")
            $q->whereRaw('LOWER(propertyName) LIKE ?', [$pattern])
                ->orWhereRaw('LOWER(COALESCE(address, "")) LIKE ?', [$pattern])
                ->orWhereRaw('LOWER(COALESCE(city, "")) LIKE ?', [$pattern])
                ->orWhereRaw('LOWER(COALESCE(sub_area, "")) LIKE ?', [$pattern])
                ->orWhereRaw('LOWER(COALESCE(community, "")) LIKE ?', [$pattern])
                ->orWhereRaw('LOWER(COALESCE(description, "")) LIKE ?', [$pattern])
                ->orWhereRaw('LOWER(COALESCE(reference, "")) LIKE ?', [$pattern])
                ->orWhereRaw('LOWER(COALESCE(unitNo, "")) LIKE ?', [$pattern])
                ->orWhereRaw('LOWER(COALESCE(zone_name, "")) LIKE ?', [$pattern])
                ->orWhereRaw('LOWER(COALESCE(dld_permit_number, "")) LIKE ?', [$pattern])
                ->orWhereRaw('LOWER(COALESCE(broker_license, "")) LIKE ?', [$pattern])
                ->orWhereRaw('LOWER(COALESCE(agent_license, "")) LIKE ?', [$pattern])
                // Posted By: search related user name and email
                ->orWhereHas('user', function ($userQuery) use ($pattern) {
                    $userQuery->whereRaw('LOWER(name) LIKE ?', [$pattern])
                        ->orWhereRaw('LOWER(COALESCE(email, "")) LIKE ?', [$pattern]);
                });
            // Numeric: match price or id if term looks like a number
            if (is_numeric($term)) {
                $q->orWhere('price', (float) $term)
                    ->orWhere('id', (int) $term)
                    ->orWhere('bedrooms', (int) $term)
                    ->orWhere('bathrooms', (int) $term);
            }
        });
    }

    public function scopeSmartSearch($query, $search)
    {
        $search = $search ? trim((string) $search) : null;
        if ($search === null || $search === '') {
            return $query;
        }

        // Escape LIKE wildcards so user input is matched literally (% and _)
        $searchEscaped = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search);
        $searchLower = strtolower($search);

        // Detect "2 bed", "3 bedroom", "studio"
        preg_match('/(\d+)\s*bed/', $searchLower, $bedMatch);
        $bedrooms = $bedMatch[1] ?? null;

        if (str_contains($searchLower, 'studio')) {
            $bedrooms = 0;
        }

        return $query->where(function ($q) use ($searchEscaped, $bedrooms) {

            // Text-based matching (escaped for consistent LIKE behavior)
            $pattern = '%' . $searchEscaped . '%';
            $q->where('propertyName', 'LIKE', $pattern)
                ->orWhere('address', 'LIKE', $pattern)
                ->orWhere('city', 'LIKE', $pattern)
                ->orWhere('sub_area', 'LIKE', $pattern)
                ->orWhere('community', 'LIKE', $pattern)
                ->orWhere('description', 'LIKE', $pattern);

            // Bedrooms matching
            if ($bedrooms !== null) {
                $q->orWhere('bedrooms', (int) $bedrooms);
            }
        });
    }

    public function userListing()
    {
        return $this->hasOne(\App\Models\UserListing::class, 'property_id');
    }



}
