<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Property;

class FavoriteController extends Controller
{
    public function toggleFavorite($propertyId)
    {
        $user = auth()->user();

        // Find the property by ID
        $property = \App\Models\Property::find($propertyId);

        if (!$property) {
            return back()->withErrors(['error' => 'Property not found.']);
        }

        // Check if already favorited
        $favorite = \App\Models\Favorite::where('user_id', $user->id)
            ->where('property_id', $property->id)
            ->first();

        if ($favorite) {
            // Remove from favorites
            $favorite->delete();
            return back()->with('success', 'Property removed from favorites.');
        } else {
            // Add to favorites
            \App\Models\Favorite::create([
                'user_id' => $user->id,
                'property_id' => $property->id,
            ]);

            return back()->with('success', 'Property added to favorites.');
        }
    }
}

