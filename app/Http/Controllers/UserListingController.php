<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserListing;
use App\Models\Property;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;

class UserListingController extends Controller
{
    public function create()
    {
        return view('add-listing');
    }

    public function store(Request $request)
    {
        // ===============================
        // 1. VALIDATION
        // ===============================
        $validated = $request->validate([
            'listing_type' => 'required|in:sell,rent',

            'title_deed'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'oqood'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'emirates_id'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',

            'property_status' => 'required|in:rented,vacant,vacant_on_transfer,off_plan',

            'rent_frequency' => 'nullable|required_if:listing_type,rent|in:year,month,custom',
            'custom_start_date' => 'nullable|required_if:rent_frequency,custom|date',
            'custom_end_date'   => 'nullable|required_if:rent_frequency,custom|date|after_or_equal:custom_start_date',

            'price' => 'required|integer',

            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // When custom is selected, store the date range (for display); rent_frequency stays 'custom'
        if (($validated['rent_frequency'] ?? '') === 'custom' && ! empty($validated['custom_start_date']) && ! empty($validated['custom_end_date'])) {
            $validated['custom_rent_range'] = $validated['custom_start_date'] . ' to ' . $validated['custom_end_date'];
        }
        unset($validated['custom_start_date'], $validated['custom_end_date']);

        // ===============================
        // 2. FILE UPLOADS (DOCS)
        // ===============================
        if ($request->hasFile('title_deed')) {
            $validated['title_deed'] = $request->file('title_deed')
                ->store('user_listings/docs', 'public');
        }

        if ($request->hasFile('oqood')) {
            $validated['oqood'] = $request->file('oqood')
                ->store('user_listings/docs', 'public');
        }

        $validated['emirates_id'] = $request->file('emirates_id')
            ->store('user_listings/docs', 'public');

        // ===============================
        // 3. IMAGES (resize & compress for faster save and smaller files)
        // ===============================
        $images = [];
        if ($request->hasFile('images')) {
            $manager = new ImageManager(new Driver());
            $maxDimension = 1200;
            $jpegQuality = 82;

            foreach ($request->file('images') as $image) {
                try {
                    $img = $manager->read($image);
                    $w = $img->width();
                    $h = $img->height();
                    if ($w > $maxDimension || $h > $maxDimension) {
                        if ($w >= $h) {
                            $img->resize(width: $maxDimension);
                        } else {
                            $img->resize(height: $maxDimension);
                        }
                    }
                    $filename = 'listing_' . uniqid() . '_' . time() . '.jpg';
                    $relPath = 'user_listings/images/' . $filename;
                    $encoded = $img->encode(new JpegEncoder(quality: $jpegQuality));
                    Storage::disk('public')->put($relPath, (string) $encoded);
                    $images[] = $relPath;
                } catch (\Throwable $e) {
                    // Fallback: store original if processing fails
                    $images[] = $image->store('user_listings/images', 'public');
                }
            }
        }

        $validated['images'] = $images;
        $validated['user_id'] = auth()->id();
        $validated['status']  = 'pending';

        // ===============================
        // 4. CREATE USER LISTING
        // ===============================
        $listing = UserListing::create($validated);

        // ===============================
        // 5. AUTO CREATE PROPERTY (UNAPPROVED)
        // ===============================
        $property = Property::create([
            'user_id' => auth()->id(),

            // sell = 1 | rent = 2
            'propertyType' => $listing->listing_type === 'sell' ? 1 : 2,

            // default category (can be edited by admin later)
            'property_category_id' => 1,
            'child_type_id' => 1,

            'propertyName' => 'Pending Admin Approval',
            'address' => 'Provided after approval',
            'latitude' => 25.2048,
            'longitude' => 55.2708,

            'builtArea' => 1,
            'price' => $listing->price,

            'status' => match ($listing->property_status) {
                'rented' => 3,
                'vacant_on_transfer' => 2,
                'vacant' => 1,
                'off_plan' => 4,
            },

            'furnished' => 'no',
            'balcony' => 0,
            'asc' => 0,

            'verified' => 0, // 🔴 IMPORTANT
        ]);

        // ===============================
        // 6. LINK PROPERTY TO LISTING
        // ===============================
        $listing->property_id = $property->id;
        $listing->save();

        // ===============================
        // 7. REDIRECT
        // ===============================
        return redirect()
            ->route('properties.my')
            ->with('success', 'Listing submitted. Property created and awaiting admin approval.');
    }

    public function index()
    {
        $listings = UserListing::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('account-my-listings', compact('listings'));
    }
}
