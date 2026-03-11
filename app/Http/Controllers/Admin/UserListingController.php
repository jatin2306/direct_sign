<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserListing;
use Illuminate\Http\Request;

class UserListingController extends Controller
{
    public function index()
    {
        $listings = UserListing::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.user-listings.index', compact('listings'));
    }

    public function approve(UserListing $listing, Request $request)
    {
        // 1. Update listing status
        $listing->status = 'approved';
        $listing->property_url = $request->property_url;
        $listing->save();

        // 2. Verify property
        if ($listing->property_id) {
            $property = Property::find($listing->property_id);
            if ($property) {
                $property->verified = true;
                $property->save();
            }
        }

        return redirect()->back()->with('success', 'Listing approved and property is now live.');
    }


    public function reject(UserListing $listing)
    {
        $listing->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Listing rejected');
    }
}
