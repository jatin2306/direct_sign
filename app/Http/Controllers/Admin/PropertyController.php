<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Property;
use App\Models\PropertyPicture;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Category;
use App\Models\ChildType;
use App\Models\Amenity;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\UserListing;

class PropertyController extends Controller
{

public function duplicate($id)
{
    DB::beginTransaction();

    try {
        $property = Property::with('pictures')->findOrFail($id);

        // Duplicate property row
        $newProperty = $property->replicate();

        // Reset listing-related fields only
        $newProperty->verified = 0;
        $newProperty->is_featured = 0;
        $newProperty->created_by_admin_id = Auth::guard('admin')->id();

        // Rename property
        $newProperty->propertyName = $property->propertyName . ' (Copy)';

        $newProperty->created_at = now();
        $newProperty->updated_at = now();

        $newProperty->save();

        /**
         * Copy all property images into public/storage/property_pictures/ so asset('storage/'.path) works.
         * This app uses public/storage as a real directory (not symlink to storage/app/public).
         */
        $pathNormalized = static function ($p) {
            $p = trim((string) $p);
            $p = preg_replace('#^public/#', '', $p);
            return $p === '' ? null : $p;
        };

        $destDir = public_path('storage/property_pictures');
        if (! File::isDirectory($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }

        $defaultDisk = config('filesystems.default');

        foreach ($property->pictures as $picture) {
            $path = $pathNormalized($picture->path);
            if ($path === null) {
                continue;
            }

            // Resolve source file: try public/storage first (where this app serves from), then disks
            $contents = null;
            $publicPath = public_path('storage/' . $path);
            if (file_exists($publicPath) && is_file($publicPath)) {
                $contents = @file_get_contents($publicPath);
            }
            if ($contents === null && Storage::disk($defaultDisk)->exists($path)) {
                $contents = Storage::disk($defaultDisk)->get($path);
            }
            if ($contents === null && Storage::disk('public')->exists($path)) {
                $contents = Storage::disk('public')->get($path);
            }
            if ($contents === null && file_exists(storage_path('app/public/' . $path))) {
                $contents = @file_get_contents(storage_path('app/public/' . $path));
            }
            if ($contents === null && file_exists(storage_path('app/' . $path))) {
                $contents = @file_get_contents(storage_path('app/' . $path));
            }
            if ($contents === null && $defaultDisk !== 'public') {
                $rootPath = Storage::disk($defaultDisk)->path($path);
                if (file_exists($rootPath)) {
                    $contents = @file_get_contents($rootPath);
                }
            }

            if ($contents === null || $contents === false || strlen($contents) === 0) {
                continue;
            }

            $newFilename = 'property_' . time() . '_' . uniqid() . '.jpg';
            $newRelativePath = 'property_pictures/' . $newFilename;
            $destPath = $destDir . '/' . $newFilename;

            if (File::put($destPath, $contents) !== false) {
                $newProperty->pictures()->create(['path' => $newRelativePath]);
            }
        }

        DB::commit();

        return back()->with('success', 'Property duplicated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}




    public function index(Request $request)
    {
        $search = trim((string) $request->get('search', ''));
        $priceMin = $request->get('priceMin');
        $priceMax = $request->get('priceMax');
        $propertyType = $request->get('propertyType');
        $category = $request->get('property_category_id');
        $childType = $request->get('child_type_id');
        $status = $request->get('status');
        $verified = $request->get('verified');
        $sortOption = $request->get('sort');
        $bedrooms = $request->get('bedrooms');
        $bathrooms = $request->get('bathrooms');
        $location = $request->get('location');

        $properties = Property::with(['user', 'category', 'childTypeRelation'])
            ->adminSearch($search)
            ->filterByPropertyType($propertyType)
            ->filterByCategory($category)
            ->filterByChildType($childType)
            ->filterByPrice($priceMin, $priceMax)
            ->filterByStatus($status)
            ->filterByVerified($verified)
            ->filterByBedrooms($bedrooms)
            ->filterByBathrooms($bathrooms)
            ->filterByLocation($location);

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
                $properties->orderBy('id', 'desc');
                break;
        }

        $totalProperty = $properties->count();
        $properties = $properties->paginate(10);

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

        $locations = Property::pluck('city')->merge(Property::pluck('sub_area'))->unique()->values();

        if ($request->ajax() || $request->wantsJson()) {
            $html = view('admin.partials.property-list-content', compact(
                'properties', 'propertyTypes', 'categories', 'childTypes', 'locations'
            ))->render();
            return response()->json(['html' => $html, 'total' => $totalProperty]);
        }

        return view('admin.property-list', compact(
            'properties', 'totalProperty', 'propertyTypes', 'statuses',
            'categories', 'childTypes', 'locations', 'search'
        ));
    }


public function edit($id)
{
    $property = Property::findOrFail($id);

    // Quick add-listing data (if exists)
    $userListing = UserListing::where('property_id', $id)->first();

    // Required dropdown / checkbox data
    $categories = Category::all();
    $childTypes = ChildType::all();
    $amenities  = Amenity::all();

    return view('admin.edit', compact(
        'property',
        'userListing',
        'categories',
        'childTypes',
        'amenities'
    ));
}



    public function update(Request $request)
{
    $propertyId = $request->route('property');
    $property = \App\Models\Property::find($propertyId);

    if (!$property) {
        abort(404, 'Property not found.');
    }

    $validated = $request->validate([
        'propertyName' => 'required|string',
        'propertyType' => 'required|string',
        'property_category_id' => 'required|exists:categories,id',
        'child_type_id' => 'required|exists:child_types,id',
        'price' => 'required|numeric',
        'address' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'city' => 'nullable|string',
        'sub_area' => 'nullable|string',
        'bedrooms' => 'nullable|integer',
        'bathrooms' => 'nullable|integer',
        'builtArea' => 'required|integer',
        'plotArea' => 'nullable|integer',
        'furnished' => 'required|string',
        'status' => 'required|string',
        'parking' => 'nullable|integer',
        'any_upgrades' => 'nullable|string',
        'amenities' => 'nullable|array',
        'pictures.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'user_id' => 'required|exists:users,id',
        'reference' => 'nullable|string|max:255',
        'broker_license' => 'nullable|string|max:255',
        'zone_name' => 'nullable|string|max:255',
        'dld_permit_number' => 'nullable|string|max:255',
        'agent_license' => 'nullable|string|max:255',
        'regulatory_image' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
        // 'description' => 'required|string',

    ]);

     // Inject user_id before updating
     $property->user_id = $validated['user_id'];

    // Handle regulatory image upload
    if ($request->hasFile('regulatory_image')) {
        // Delete old file if exists
        if ($property->regulatory_image) {
            Storage::disk('public')->delete($property->regulatory_image);
        }
        // Store new file and **update path in column**
        $imagePath = $request->file('regulatory_image')->store('regulatory_images', 'public');
        $validated['regulatory_image'] = $imagePath;
    }

    // Update basic fields
    $property->update($validated);

    // Update amenities
    $property->amenities = $validated['amenities'] ?? [];
    $property->save();

    

    // Handle new image uploads if any
    if ($request->hasFile('pictures')) {
        $destDir = public_path('storage/property_pictures');
        if (! File::isDirectory($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }

        foreach ($request->file('pictures') as $picture) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($picture)->resize(800, 800);

            $tempDirectory = storage_path('app/temp');
            if (! file_exists($tempDirectory)) {
                mkdir($tempDirectory, 0777, true);
            }

            $tempPath = tempnam($tempDirectory, 'property_');
            $image->save($tempPath);

            $uniqueId = uniqid();
            $filename = 'property_' . time() . '_' . $uniqueId . '.jpg';
            $pathForDatabase = 'property_pictures/' . $filename;
            $destPath = $destDir . '/' . $filename;

            if (File::put($destPath, file_get_contents($tempPath)) !== false) {
                $property->pictures()->create(['path' => $pathForDatabase]);
            }
            @unlink($tempPath);
        }
    }


    return redirect()->route('admin.properties.edit', $property->id)->with('success', 'Property updated successfully.');
}

// public function update(Request $request, $property)
// {
//     $property = Property::findOrFail($property);

//     $property->update([
//         'broker_license' => $request->broker_license,
//         'propertyName'   => $request->propertyName,
//         'price'          => $request->price,
//     ]);

//     return back()->with('success', 'Property updated');
// }



    public function deleteImage($id)
    {
        $picture = PropertyPicture::findOrFail($id);

        // Delete image from storage
        if ($picture->path && Storage::exists('public/' . $picture->path)) {
            Storage::delete('public/' . $picture->path);
        }

        // Delete from DB
        $picture->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    public function toggleVerified(Request $request)
    {
        $propertyId = $request->route('property');
        $property = \App\Models\Property::find($propertyId);

        if (!$property) {
            return back()->with('error', 'Property not found.');
        }

        $property->verified = !$property->verified;
        $property->save();

        return back()->with('success', 'Property verification status updated.');
    }

    public function destroy($id)
{
    $property = Property::findOrFail($id);

    // Delete all related images
    foreach ($property->pictures as $picture) {
        if ($picture->path && Storage::disk('public')->exists($picture->path)) {
            Storage::disk('public')->delete($picture->path);
        }
        $picture->delete();
    }

    $property->favorites()->delete();
    $property->reviews()->delete();

    $property->delete();

    return back()->with('success', 'Property deleted successfully.');
}




}
