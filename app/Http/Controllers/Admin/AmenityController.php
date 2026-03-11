<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenity;

class AmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::all();
        return view('admin.amenities.index', compact('amenities'));
    }

    public function create()
    {
        return view('admin.amenities.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $amenity = Amenity::create($request->only('name'));
        return redirect()->route('admin.amenities.index')->with('success', 'Amenity created.');
    }

    public function edit($amenity)
    {
        $amenity = \App\Models\Amenity::find($amenity);
        if (!$amenity) {
            return back()->with('error', 'Amenity not found.');
        }
        return view('admin.amenities.edit', compact('amenity'));
    }

    public function update(Request $request, $amenity)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $amenity = \App\Models\Amenity::find($amenity);
        if (!$amenity) {
            return back()->with('error', 'Amenity not found.');
        }
        $amenity->name = $request->input('name');
        $amenity->save();
        return redirect()->route('admin.amenities.index')->with('success', 'Amenity updated.');
    }


    public function destroy($amenity)
{
    $amenity = \App\Models\Amenity::find($amenity);
    if (!$amenity) {
        return back()->with('error', 'Amenity not found.');
    }

    $usedCount = \App\Models\Property::where(function($q) use ($amenity) {
        $q->whereJsonContains('amenities', $amenity->id)
          ->orWhereJsonContains('amenities', (string)$amenity->id);
    })->count();

    if ($usedCount > 0) {
        return back()->with('error', 'Cannot delete: Amenity is used in ' . $usedCount . ' property(s).');
    }

    $amenity->delete();

    return back()->with('success', 'Amenity deleted.');
}


}
