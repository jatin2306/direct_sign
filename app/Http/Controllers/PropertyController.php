<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Property;
use App\Models\PropertyPicture;
use App\Models\Category;
use App\Models\ChildType;
use App\Models\Amenity;
use App\Models\Review;
use App\Models\User;
use App\Notifications\NotifyMeNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Http;


class PropertyController extends Controller
{   
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        $priceMin = $request->has('priceMin') && $request->get('priceMin') !== '' && is_numeric(str_replace(',', '', $request->get('priceMin')))
            ? (int) round((float) str_replace(',', '', $request->get('priceMin'))) : null;
        $priceMax = $request->has('priceMax') && $request->get('priceMax') !== '' && is_numeric(str_replace(',', '', $request->get('priceMax')))
            ? (int) round((float) str_replace(',', '', $request->get('priceMax'))) : null;
        $propertyType = $request->get('propertyType'); // Sale or Rent
        $category = $request->get('property_category_id'); // Filter for property category
        $childType = $request->get('child_type_id'); // Filter for child type
        $status = $request->get('status'); // Active or Inactive
        $sortOption = $request->get('sort', ''); // Sort by price or date
        $bedrooms = $request->get('bedrooms', null); // Number of bedrooms
        $bathrooms = $request->get('bathrooms', null); // Number of bathrooms
        $areaMin = $request->has('areaMin') && $request->get('areaMin') !== '' && is_numeric(str_replace(',', '', $request->get('areaMin')))
            ? (int) round((float) str_replace(',', '', $request->get('areaMin'))) : null;
        $areaMax = $request->has('areaMax') && $request->get('areaMax') !== '' && is_numeric(str_replace(',', '', $request->get('areaMax')))
            ? (int) round((float) str_replace(',', '', $request->get('areaMax'))) : null;
        $location = $request->filled('location') ? trim((string) $request->get('location')) : null;
        if ($location === '') {
            $location = null;
        }

        // Apply query scopes
        $properties = Property::with(['pictures', 'user', 'category', 'childTypeRelation'])
            ->filterByPropertyType($propertyType)
            ->filterByCategory($category)
            ->filterByChildType($childType)
            ->filterByPrice($priceMin, $priceMax)
            ->filterByArea($areaMin, $areaMax)
            ->filterByStatus($status)
            ->filterByBedrooms($bedrooms) // Scope for bedrooms
            ->filterByBathrooms($bathrooms) // Scope for bathrooms
            // ->filterByLocation($location) // Scope for location
            ->smartSearch($location)
            ->verified(); // Only fetch verified properties
    
            // Apply sorting logic
            switch ($sortOption) {
                case 'price_asc':
                    $properties->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $properties->orderBy('price', 'desc');
                    break;
                case 'date_asc':
                    $properties->orderBy('created_at', 'asc');
                    break;
                case 'date_desc':
                    $properties->orderBy('created_at', 'desc');
                    break;
                default:
                    $properties->inRandomOrder(); // Mixed / random listings
                    break;
            }

        $totalProperty = $properties->count(); // Get the total number of properties
        $properties = $properties->paginate(10)->withQueryString(); // Keep filters on pagination
        
       
        // Fetch data for filter options (verified only; only options with count > 0 for sidebar)
        $propertyTypes = [
            '1' => 'Buy',
            '2' => 'Rent',
            '3' => 'Off Plan',
        ];
        $propertyTypeCounts = [
            'Buy' => Property::verified()->filterByPropertyType('1')->count(),
            'Rent' => Property::verified()->filterByPropertyType('2')->count(),
            'Off Plan' => Property::verified()->filterByPropertyType('3')->count(),
        ];
        $statuses = [
            '1' => 'Vacant',
            '2' => 'Vacant on Transfer',
            '3' => 'Rented',
            '4' => 'Off Plan/Under Construction',
        ];
        $statusCounts = [];
        foreach (array_keys($statuses) as $key) {
            $statusCounts[$key] = Property::verified()->where('status', $key)->count();
        }
        
        // Categories: count only verified properties, then keep only those with count > 0
        $categories = Category::withCount(['properties' => function ($q) {
            $q->where('verified', true);
        }])->get()->filter(function ($cat) {
            return $cat->properties_count > 0;
        })->values();
        // Child types: count only verified properties, keep only with count > 0 (avoids duplicates and empty options)
        $childTypes = ChildType::withCount(['properties' => function ($q) {
            $q->where('verified', true);
        }])->get()->filter(function ($ct) {
            return $ct->properties_count > 0;
        })->values();

        // Map the selected category and child type to their names
        $selectedCategory = $categories->firstWhere('id', $category);
        $selectedChildType = $childTypes->firstWhere('id', $childType);
        
        // Distinct locations (city + sub_area), exclude empty and "Not Specified"
        $locations = Property::verified()
            ->distinct()
            ->pluck('city')
            ->merge(Property::verified()->distinct()->pluck('sub_area'))
            ->map(function ($name) {
                return $name ? trim((string) $name) : null;
            })
            ->filter(function ($name) {
                return $name !== null && $name !== '' && strtolower($name) !== 'not specified';
            })
            ->unique()
            ->values()
            ->sort()
            ->values();
        
        // Fetch suggested properties if no results are found
        $suggestedProperties = [];
        if ($properties->isEmpty()) {
            $suggestedProperties = Property::with(['pictures', 'user', 'category', 'childTypeRelation'])
                ->where('verified', true) // Only verified properties
                ->orderBy('id', 'desc') // Fetch the latest properties
                ->take(5) // Limit to 5 properties
                ->get();
        }


        return view('property-list', [
            'properties' => $properties,
            'totalProperty' => $totalProperty,
            'propertyTypes' => $propertyTypes,
            'propertyTypeCounts' => $propertyTypeCounts,
            'statuses' => $statuses,
            'statusCounts' => $statusCounts,
            'categories' => $categories,
            'childTypes' => $childTypes,
            'locations' => $locations,
            'filters' => [
                'propertyType' => $propertyTypes[$propertyType] ?? null,
                'property_category_id' => $selectedCategory ? $selectedCategory->name : null,
                'child_type_id' => $selectedChildType ? $selectedChildType->name : null,
                'priceMin' => $priceMin,
                'priceMax' => $priceMax,
                'status' => $statuses[$status] ?? null,
                'location' => $location, // Include location
                'bedrooms' => $bedrooms, // Include bedrooms
                'bathrooms' => $bathrooms, // Include bathrooms
                'sort' => $sortOption,
            ],
            'suggestedProperties' => $suggestedProperties, // Pass suggested properties to the view
        ]);
    }


public function scopeFilterByStatus($query, $status)
{
    // ALL
    if ($status === null || $status === '') {
        return $query;
    }

    // READY = everything except Off-Plan (status 4)
    if ($status === 'ready') {
        return $query->where('status', '!=', '4');
    }

    // OFF-PLAN ONLY
    if ($status === '4') {
        return $query->where('status', '4');
    }

    // SPECIFIC STATUS (1,2,3)
    return $query->where('status', (string) $status);
}




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        // Validate the request data  
        try {      
        $data = $request->validate([
            'propertyType' => 'required|string',
            'property_category_id' => 'required|exists:categories,id',
            'child_type_id' => 'required|exists:child_types,id',
            'propertyName' => 'required|string',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'builtArea' => 'required|integer',
            'plotArea' => 'nullable|integer',
            'unitNo' => 'nullable|string',
            'floorNo' => 'nullable|string',
            'furnished' => 'required|string',
            'balcony' => 'required|boolean',
            'community' => 'nullable|string',
            'view' => 'nullable|string',
            'parking' => 'nullable|integer',
            'status' => 'required|string',
            'any_upgrades' => 'nullable|string',
            'communityFee' => 'nullable|boolean',
            'mortgaged' => 'nullable|boolean',
            'price' => 'required|integer',
            'asc' => 'required|integer',
            'amenities' => 'nullable|array',
            // 'pictures.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pictures'   => 'nullable|array|max:10',
            'pictures.*' => 'image|mimes:jpeg,png,jpg|max:5120', // 5MB per image

            'needs_photographer' => 'nullable|boolean',
        ]);
        
        // Extract the city from the address using your method
        $address = $request->address;
        $location = $this->extractLocationFromAddress($address);
        $data['city'] = $location['city'];
        $data['sub_area'] = $location['sub_area'];

        // Set the user_id to the currently authenticated user
        $data['user_id'] = Auth::id();
        
        // Set needs_photographer based on user selection
        $data['needs_photographer'] = $request->has('needs_photographer');

        //insert data into the database
        $property = Property::create($data);

        if (!$data['needs_photographer'] && $request->hasFile('pictures')) {
            // Loop through each uploaded image
            foreach ($request->file('pictures') as $picture) {
                // Initialize the ImageManager with default configuration (GD driver is default)
                $manager = new ImageManager(new Driver());  // Default driver (GD)
        
                // Read the image and create an image instance
                $image = $manager->read($picture);  // 'make' is the correct method for reading images
        
                // Resize the image to 800x800
                $image->resize(800, 800);
        
                // Define a custom temporary directory
                $tempDirectory = storage_path('app/temp');  // Using Laravel's storage folder for temp files
                if (!file_exists($tempDirectory)) {
                    mkdir($tempDirectory, 0777, true);  // Create the directory if it doesn't exist
                }
        
                // Save to a temporary file within the custom directory
                $tempPath = tempnam($tempDirectory, 'property_');
                $image->save($tempPath);
        
                // Generate a unique filename based on the current timestamp
                $uniqueId = uniqid(); // Generates a unique identifier
                $filename = 'property_' . time() . '_' . $uniqueId . '.jpg';

                // Define the full storage path for saving the image
                // $storagePath = 'public/property_pictures/' . $filename;
                $storagePath = 'property_pictures/' . $filename;

                // Save the image to permanent storage
                Storage::put($storagePath, file_get_contents($tempPath));

                // Delete the temporary file
                unlink($tempPath);

                // Remove 'public/' before saving to database
                $pathForDatabase = 'property_pictures/' . $filename;

                // Save the path in the database
                $property->pictures()->create(['path' => $pathForDatabase]);

            }
        }

        return redirect()->route('add.listing')->with('success', 'Property created successfully and Under Review by Admin');
        } catch (\Exception $e) {
            dd('Error:', $e->getMessage());
            //return redirect()->back()->with('error', 'An error occurred while creating the property. Please try again.');
        }
    }

    /**
     * Extract the address from the Google Maps API response and return the city name.
     */
    public function extractLocationFromAddress($address)
    {
        $apiKey = 'AIzaSyD7PU198Ir_uLOzaOK6hete5Rm5gDmWawI'; // Replace with your API key
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . $apiKey;

        $response = Http::get($url);
        $data = $response->json();

        if ($response->successful() && isset($data['results'][0])) {
            $city = null;
            $subArea = 'Not Specified';

            foreach ($data['results'][0]['address_components'] as $component) {
                if (in_array('locality', $component['types'])) {
                    $city = $component['long_name']; // City (e.g., Dubai)
                }
                if (in_array('sublocality', $component['types'])) {
                    $subArea = $component['long_name']; // Sub-area (e.g., Dubai Airport)
                }
            }
            return ['city' => $city, 'sub_area' => $subArea];
        }

        return null; // Return null if no location data is found
    }


    /**
     * Display the specified resource. Accepts SEO slug or numeric ID.
     * Slug is computed (ends with -{id}), no DB column needed.
     */
    public function show($slugOrId)
    {
        if (is_numeric($slugOrId)) {
            $property = Property::with('pictures', 'user', 'category', 'childTypeRelation')->findOrFail($slugOrId);
            // Redirect to SEO slug URL for better ranking (301 permanent)
            return redirect()->route('property.show', $property->slug, 301);
        }

        // Slug format: ...-{id} — extract id from end
        if (!preg_match('/-(\d+)$/', $slugOrId, $m)) {
            abort(404);
        }
        $property = Property::with('pictures', 'user', 'category', 'childTypeRelation')->findOrFail($m[1]);
        $id = $property->id;

        // Check if the user has already reviewed this property
        $review = Review::where('property_id', $id)
        ->where('user_id', Auth::id())
        ->first();
        // Fetch amenities names from the 'amenities' table using the stored amenities array in the property
        $amenities = [];
        
        if (is_array($property->amenities)) {
            $amenities = Amenity::whereIn('id', $property->amenities)->pluck('name')->toArray();
        }

         // Fetch similar properties along with their pictures
            $similarProperties = Property::with('pictures')
            ->where('id', '!=', $id) // Exclude the current property
            ->where('property_category_id', $property->property_category_id) // Similar category (example)
            ->take(5) // Limit to 5 similar properties
            ->get();

        if ($property->propertyType === 2) {
            
            return view('property-details-rent', [
                'property' => $property,'amenities' => $amenities, 'review' => $review, 'similarProperties' => $similarProperties,
                'propertyTypes' => [
                    '1' => 'Sale',
                    '2' => 'Rent',
                    '3' => 'Off Plan',
                ],
                'propertyViews' => [
                    '1' => 'Sea',
                    '2' => 'City',
                    '3' => 'Garden',
                ],
                'propertyStatus' => [
                    '1' => 'Vacant',
                    '2' => 'Vacant on Transfer',
                    '3' => 'Rented',
                    '4' => 'Off Plan/Under Construction',
                    
                ],
                'propertyCommunityFee' => [
                    '0' => 'No',
                    '1' => 'Yes',
                ],
                'propertyMortgaged' => [
                    '0' => 'No',
                    '1' => 'Yes',
                ],
               
            ]);
        }
        
       
        return view('property-details', [
            'property' => $property,'amenities' => $amenities, 'review' => $review, 'similarProperties' => $similarProperties,
            'propertyTypes' => [
                '1' => 'Sale',
                '2' => 'Rent',
                '3' => 'Off Plan',
            ],
            'propertyViews' => [
                '1' => 'Sea',
                '2' => 'City',
                '3' => 'Garden',
            ],
            'propertyStatus' => [
                    '1' => 'Vacant',
                    '2' => 'Vacant on Transfer',
                    '3' => 'Rented',
                    '4' => 'Off Plan/Under Construction',
                    
                ],
            'propertyCommunityFee' => [
                '0' => 'No',
                '1' => 'Yes',
            ],
            'propertyMortgaged' => [
                '0' => 'No',
                '1' => 'Yes',
            ],
           
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

public function update(Request $request, string $id)
{
    dd('HIT UPDATE', $request->all());

    $property = Property::findOrFail($id);

    $property->broker_license = $request->broker_license;
    $property->save();

    return redirect()->back()->with('success', 'Property updated');
}


    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
}
