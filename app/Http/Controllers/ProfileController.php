<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\Property;
use App\Models\Favorite;
use App\Models\Transaction;
use App\Models\UserListing;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('dashboard', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
     
public function update(Request $request): RedirectResponse
{
    $user = auth()->user();

    // ✅ Validate input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'full_phone_number' => ['required', 'regex:/^\+\d{6,15}$/'], // expects +971501234567
        'current_password' => 'required|string',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    // ✅ Verify current password
    if (!Hash::check($validated['current_password'], $user->password)) {
        return back()->withErrors(['current_password' => 'The current password is incorrect.']);
    }

    // ✅ Update basic profile info
    $user->name = $validated['name'];
    $user->phone_number = $validated['full_phone_number']; // Save full international format

    // ✅ If password provided, update it securely
    if (!empty($validated['password'])) {
        Auth::logoutOtherDevices($validated['current_password']);
        $user->password = Hash::make($validated['password']);
    }

    $user->save();

    return back()->with('success', 'Profile updated successfully.');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Show the user's listed properties.
     */
    public function myProperties()
    {
        
        // Fetch properties for the logged-in user
        $properties = Property::with(['pictures', 'user', 'category', 'childTypeRelation'])
            ->where('user_id', auth()->id()) // Restrict to the logged-in user's properties
            ->orderByRaw('CASE WHEN verified = false THEN 0 ELSE 1 END') // Unverified first
            ->orderBy('id', 'desc'); // Order by the latest properties

        $properties = $properties->paginate(10); // Paginate results, 10 properties per page
        $totalProperty = $properties->total(); // Total properties count for the logged-in user
        // Fetch data for filter options
        $propertyTypes = [
            '1' => 'Sale',
            '2' => 'Rent',
        ];
        return view('account-my-properties', [
            'properties' => $properties,
            'totalProperty' => $totalProperty,
            'propertyTypes' => $propertyTypes,
        ]);
    }
   // Show the user's saved properties
   public function savedProperties()
    {
        $user = auth()->user();

        // Fetch properties saved by the logged-in user
        $properties = Property::with(['pictures', 'user', 'category', 'childTypeRelation'])
            ->whereIn('id', $user->favorites()->pluck('property_id')) // Fetch properties based on saved IDs
            ->orderByRaw('CASE WHEN verified = false THEN 0 ELSE 1 END') // Unverified properties first
            ->orderBy('id', 'desc') // Order by the latest properties
            ->paginate(10); // Paginate results, 10 properties per page

        $totalProperty = $properties->total(); // Total saved properties count

        // Fetch data for filter options
        $propertyTypes = [
            '1' => 'Sale',
            '2' => 'Rent',
        ];

        return view('account-saved-properties', [
            'properties' => $properties,
            'totalProperty' => $totalProperty,
            'propertyTypes' => $propertyTypes,
        ]);
    }
    
    public function myTransactions()
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->orderBy('transaction_date', 'desc')
            ->paginate(10); // Paginate transactions

        return view('account-user-transactions', compact('transactions'));
    }

    public function myListings()
    {
        $listings = UserListing::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('account-my-listings', compact('listings'));
    }
}
