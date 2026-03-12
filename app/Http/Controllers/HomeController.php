<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\FeaturedSection;
use App\Models\Property;
use App\Models\Category;
use App\Models\ChildType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
    {
    $banners = Banner::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();

    // Fetch featured properties for the homepage without caching
    $featuredProperties = Property::with(['pictures', 'childTypeRelation'])
        ->where('is_featured', true)
        ->verified()
        ->take(5)
        ->get();

    // Admin-configured featured sections: property carousels only (developers carousel is separate)
    $featuredSections = FeaturedSection::where('is_active', true)
        ->where(function ($q) {
            $q->where('type', 'properties')->orWhereNull('type');
        })
        ->with(['properties' => function ($q) {
            $q->with(['pictures', 'childTypeRelation']);
        }])
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get();

    // Developers carousel: first active featured section of type "developers" (same Add Carousel form)
    $developersSection = FeaturedSection::where('is_active', true)
        ->where('type', 'developers')
        ->with('developers')
        ->orderBy('sort_order')
        ->orderBy('id')
        ->first();
    $developers = collect();
    if ($developersSection && $developersSection->developers->isNotEmpty()) {
        $developers = $developersSection->developers->map(function ($d) {
            $projects = 0;
            if (! empty($d->search_slug)) {
                $projects = Property::where('address', 'LIKE', '%' . $d->search_slug . '%')->count();
            }
            return (object) [
                'name'      => $d->name,
                'logo_text' => $d->logo_text ?: strtoupper(explode(' ', trim($d->name))[0] ?? ''),
                'logo_dark' => $d->logo_dark,
                'projects'  => $projects,
            ];
        });
    }

    // Image carousel: first active featured section of type "image_carousel"
    $imageCarouselSection = FeaturedSection::where('is_active', true)
        ->where('type', 'image_carousel')
        ->with('images')
        ->orderBy('sort_order')
        ->orderBy('id')
        ->first();




    // Capture the 'location' query parameter
    $location = $request->get('location');

    // Get the currently selected filters from the request, if any.
    $propertyType = $request->get('propertyType', null);
    $category = $request->get('property_category_id', null);
    $childType = $request->get('child_type_id', null);
    $bedrooms = $request->get('bedrooms', null);
    $bathrooms = $request->get('bathrooms', null);
    $location = $request->get('location', null);
    
    // Fetch data for filter options
    $propertyTypes = [
        '1' => 'Buy',
        '2' => 'Rent',
        '3' => 'Off Plan',
    ];
    
    $statuses = [
        '1' => 'Vacant',
        '2' => 'Vacant on Transfer',
        '3' => 'Rented',
        '4' => 'Off Plan/Under Construction',
    ];

    $categories = Category::withCount('properties')->get(); 
    $childTypes = ChildType::withCount('properties')->get();

    // Map the selected category and child type to their names
    $selectedCategory = $categories->firstWhere('id', $category);
    $selectedChildType = $childTypes->firstWhere('id', $childType);

    // Fetch distinct locations (city and sub_area)
    $locations = Property::distinct()
        ->pluck('city')
        ->merge(Property::distinct()->pluck('sub_area'))
        ->unique()
        ->values();

    // If 'location' is provided, fetch properties for the listing page
    $properties = null;
    if ($location) {
        $properties = Property::where('address', 'LIKE', '%' . $location . '%')->paginate(10);
    }
    
    // Locations for which you want to show property counts
    $locationsFeatured = ['Dubai', 'Abu Dhabi', 'Sharjah', 'Downtown Dubai', 'Palm Jumeirah'];

    // Get property counts for each location
    $propertyCounts = [];
    foreach ($locationsFeatured as $loc) {
        $propertyCounts[$loc] = Property::where('address', 'LIKE', '%' . $loc . '%')->count();
    }

    // Fetch the available bedroom and bathroom options
    $bedroomOptions = range(1, 10); // Or dynamically fetch based on your data
    $bathroomOptions = range(1, 10); // Same for bathrooms

    return view('home', [
        'banners' => $banners,
        'featuredProperties' => $featuredProperties,
        'featuredSections' => $featuredSections,
        'developersSection' => $developersSection,
        'developers' => $developers,
        'imageCarouselSection' => $imageCarouselSection,
        'properties' => $properties,
        'location' => $location,
        'propertyCounts' => $propertyCounts,
        'propertyTypes' => $propertyTypes,
        'categories' => $categories,
        'childTypes' => $childTypes,
        'locations' => $locations,
        'bedroomOptions' => $bedroomOptions,
        'bathroomOptions' => $bathroomOptions,
        'statuses' => $statuses,
    ]);
   
}

    
}

