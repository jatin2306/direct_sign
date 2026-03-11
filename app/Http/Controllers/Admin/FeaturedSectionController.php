<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeaturedSection;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeaturedSectionController extends Controller
{
    /**
     * Properties that are already in a featured section (optionally excluding one section for edit).
     */
    private function getUsedPropertyIds(?int $excludeSectionId = null): array
    {
        $query = DB::table('featured_section_property')->select('property_id');
        if ($excludeSectionId !== null) {
            $query->where('featured_section_id', '!=', $excludeSectionId);
        }
        return $query->pluck('property_id')->unique()->values()->all();
    }

    /**
     * Properties available for the dropdown (not already in another section).
     */
    /**
     * Only approved (verified) properties are available for carousels.
     */
    private function getAvailableProperties(?int $excludeSectionId = null)
    {
        $usedIds = $this->getUsedPropertyIds($excludeSectionId);
        $query = Property::query()->verified()->orderBy('propertyName');
        if (! empty($usedIds)) {
            $query->whereNotIn('id', $usedIds);
        }
        return $query->get(['id', 'propertyName', 'address', 'price', 'propertyType']);
    }

    public function index()
    {
        $sections = FeaturedSection::withCount('properties')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
        return view('admin.featured-sections.index', compact('sections'));
    }

    public function create()
    {
        $availableProperties = $this->getAvailableProperties();
        return view('admin.featured-sections.create', compact('availableProperties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'heading'            => 'nullable|string|max:500',
            'heading_placement'  => 'required|string|in:left,right,center',
            'sort_order'         => 'nullable|integer|min:0',
            'is_active'          => 'nullable|boolean',
            'property_ids'       => 'required|array',
            'property_ids.*'     => 'required|integer|exists:properties,id',
        ], [
            'property_ids.required' => 'Please add at least one property to this carousel.',
        ]);

        $propertyIds = array_values(array_unique(array_map('intval', $validated['property_ids'])));
        if (empty($propertyIds)) {
            return redirect()->back()->withErrors(['property_ids' => 'At least one property is required.'])->withInput();
        }

        $usedIds = $this->getUsedPropertyIds(null);
        $conflict = array_intersect($propertyIds, $usedIds);
        if (! empty($conflict)) {
            return redirect()->back()->withErrors(['property_ids' => 'One or more selected properties are already in another carousel.'])->withInput();
        }

        $section = FeaturedSection::create([
            'title'             => $validated['title'],
            'heading'           => $validated['heading'] ?? null,
            'heading_placement' => $validated['heading_placement'],
            'sort_order'        => (int) ($request->input('sort_order', 0)),
            'is_active'         => $request->boolean('is_active', true),
        ]);

        $pivot = [];
        foreach (array_values($propertyIds) as $i => $id) {
            $pivot[$id] = ['sort_order' => $i];
        }
        $section->properties()->sync($pivot);

        return redirect()->route('admin.featured-sections.index')->with('success', 'Carousel created.');
    }

    public function edit($id)
    {
        $section = FeaturedSection::with('properties')->findOrFail($id);
        $availableProperties = $this->getAvailableProperties($section->id);
        $selectedIds = $section->properties->pluck('id')->map(fn ($pid) => (int) $pid)->values()->toArray();
        return view('admin.featured-sections.edit', compact('section', 'availableProperties', 'selectedIds'));
    }

    public function update(Request $request, $id)
    {
        $section = FeaturedSection::findOrFail($id);

        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'heading'            => 'nullable|string|max:500',
            'heading_placement'  => 'required|string|in:left,right,center',
            'sort_order'         => 'nullable|integer|min:0',
            'is_active'          => 'nullable|boolean',
            'property_ids'       => 'required|array',
            'property_ids.*'     => 'required|integer|exists:properties,id',
        ], [
            'property_ids.required' => 'Please add at least one property to this carousel.',
        ]);

        $propertyIds = array_values(array_unique(array_map('intval', $validated['property_ids'])));
        if (empty($propertyIds)) {
            return redirect()->back()->withErrors(['property_ids' => 'At least one property is required.'])->withInput();
        }

        $usedIds = $this->getUsedPropertyIds($section->id);
        $conflict = array_intersect($propertyIds, $usedIds);
        if (! empty($conflict)) {
            return redirect()->back()->withErrors(['property_ids' => 'One or more selected properties are already in another carousel.'])->withInput();
        }

        $section->update([
            'title'             => $validated['title'],
            'heading'           => $validated['heading'] ?? null,
            'heading_placement' => $validated['heading_placement'],
            'sort_order'        => (int) ($request->input('sort_order', 0)),
            'is_active'         => $request->boolean('is_active', true),
        ]);

        $pivot = [];
        foreach (array_values($propertyIds) as $i => $pid) {
            $pivot[$pid] = ['sort_order' => $i];
        }
        $section->properties()->sync($pivot);

        return redirect()->route('admin.featured-sections.index')->with('success', 'Carousel updated.');
    }

    public function destroy($id)
    {
        $section = FeaturedSection::findOrFail($id);
        $section->delete();
        return redirect()->route('admin.featured-sections.index')->with('success', 'Carousel deleted.');
    }
}
