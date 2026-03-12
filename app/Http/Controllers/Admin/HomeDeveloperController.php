<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeDeveloper;
use App\Models\Property;
use Illuminate\Http\Request;

class HomeDeveloperController extends Controller
{
    public function index()
    {
        $developers = HomeDeveloper::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.developers.index', compact('developers'));
    }

    public function create()
    {
        return view('admin.developers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'logo_text'  => 'nullable|string|max:100',
            'logo_dark'  => 'nullable|boolean',
            'search_slug'=> 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'nullable|boolean',
        ]);

        $validated['sort_order'] = (int) ($request->input('sort_order', 0));
        $validated['logo_dark'] = $request->boolean('logo_dark');
        $validated['is_active'] = $request->boolean('is_active', true);

        HomeDeveloper::create($validated);

        return redirect()->route('admin.developers.index')->with('success', 'Developer added to homepage carousel.');
    }

    public function edit(HomeDeveloper $developer)
    {
        return view('admin.developers.edit', compact('developer'));
    }

    public function update(Request $request, HomeDeveloper $developer)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'logo_text'  => 'nullable|string|max:100',
            'logo_dark'  => 'nullable|boolean',
            'search_slug'=> 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'nullable|boolean',
        ]);

        $validated['sort_order'] = (int) ($request->input('sort_order', 0));
        $validated['logo_dark'] = $request->boolean('logo_dark');
        $validated['is_active'] = $request->boolean('is_active', true);

        $developer->update($validated);

        return redirect()->route('admin.developers.index')->with('success', 'Developer updated.');
    }

    public function destroy(HomeDeveloper $developer)
    {
        $developer->delete();
        return redirect()->route('admin.developers.index')->with('success', 'Developer removed from carousel.');
    }
}
