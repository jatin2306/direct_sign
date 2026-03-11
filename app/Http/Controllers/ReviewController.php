<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ReviewController extends Controller
{
    public function store(Request $request)
{   
    //dd($request->all());
    $request->validate([
        'property_id' => 'required|exists:properties,id',
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'nullable|string|max:1000',
    ], [
        'property_id.required' => 'Please select a valid property.',
        'rating.required' => 'Please provide a rating.',
        'rating.integer' => 'Rating must be a number.',
        'rating.min' => 'Rating must be between 1 and 5.',
        'rating.max' => 'Rating cannot be more than 5.',
        'review.max' => 'Review cannot exceed 1000 characters.',
    ]);

    // Check if the user has already submitted a review for the property
    $existingReview = Review::where('property_id', $request->property_id)
                            ->where('user_id', auth()->id())
                            ->first();
                            
    if ($existingReview) {
        // If the user already has a review, update it instead of creating a new one
        $existingReview->rating = $request->rating;
        $existingReview->review = $request->review;
        $existingReview->save();

        return redirect()->back()->with('success', 'Your review has been updated!');
    }

    // Proceed with saving the review if validation passes
    Review::create([
        'property_id' => $request->property_id,
        'user_id' => auth()->id(),
        'rating' => $request->rating,
        'review' => $request->review,
    ]);

    return redirect()->back()->with('success', 'Review submitted successfully!');
}

}
