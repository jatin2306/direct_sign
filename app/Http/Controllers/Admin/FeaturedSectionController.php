<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeaturedSection;
use App\Models\FeaturedSectionDeveloper;
use App\Models\FeaturedSectionImage;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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

    private function carouselImagesStoragePath(): string
    {
        $path = public_path('storage/carousel-images');
        if (! File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true);
        }
        return $path;
    }

    private function normalizeColor(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }
        $value = trim($value);
        if (preg_match('/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/', $value)) {
            return $value;
        }
        if (preg_match('/^[a-zA-Z]+$/', $value) && strlen($value) <= 20) {
            return $value;
        }
        if (preg_match('/^rgb\s*\(\s*\d+\s*,\s*\d+\s*,\s*\d+\s*\)$/', $value)) {
            return $value;
        }
        if (preg_match('/^rgba\s*\(/', $value) && strlen($value) <= 50) {
            return $value;
        }
        return null;
    }

    public function index()
    {
        $sections = FeaturedSection::withCount('properties')
            ->withCount('developers')
            ->withCount('images')
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
        $type = $request->input('type', 'properties');
        $type = in_array($type, ['properties', 'developers', 'image_carousel'], true) ? $type : 'properties';

        if ($type === 'image_carousel') {
            $request->validate([
                'title'              => 'required|string|max:255',
                'heading_placement'  => 'required|string|in:left,right,center',
                'sort_order'         => 'nullable|integer|min:0',
                'is_active'          => 'nullable|boolean',
                'slides'             => 'required|array|min:1',
                'slides.*.image'     => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
                'slides.*.heading'   => 'nullable|string|max:255',
                'slides.*.second_heading' => 'nullable|string|max:255',
                'slides.*.heading_order'  => 'nullable|integer|in:1,2',
                'slides.*.cta_url'   => 'nullable|string|max:500',
                'slides.*.background_color' => 'nullable|string|max:20',
            ], [
                'slides.required' => 'Add at least one image slide.',
                'slides.*.image.required' => 'Each slide must have an image.',
            ]);

            $section = FeaturedSection::create([
                'type'              => 'image_carousel',
                'title'             => $request->input('title'),
                'heading'           => null,
                'heading_placement' => $request->input('heading_placement', 'left'),
                'sort_order'        => (int) $request->input('sort_order', 0),
                'is_active'         => $request->boolean('is_active', true),
            ]);

            foreach (array_values($request->input('slides', [])) as $i => $slide) {
                if (! $request->hasFile('slides.' . $i . '.image')) {
                    continue;
                }
                $file = $request->file('slides.' . $i . '.image');
                $name = Str::random(40) . '.' . $file->getClientOriginalExtension();
                $file->move($this->carouselImagesStoragePath(), $name);
                $section->images()->create([
                    'image_path'       => 'carousel-images/' . $name,
                    'heading'          => $slide['heading'] ?? null,
                    'second_heading'   => $slide['second_heading'] ?? null,
                    'heading_order'    => (int) ($slide['heading_order'] ?? 1),
                    'cta_url'          => $slide['cta_url'] ?? null,
                    'background_color' => $this->normalizeColor($slide['background_color'] ?? null),
                    'sort_order'       => $i,
                ]);
            }

            return redirect()->route('admin.featured-sections.index')->with('success', 'Image carousel created.');
        }

        if ($type === 'developers') {
            $validated = $request->validate([
                'title'      => 'required|string|max:255',
                'heading'    => 'nullable|string|max:500',
                'sort_order' => 'nullable|integer|min:0',
                'is_active'  => 'nullable|boolean',
                'developers' => 'required|array|min:1',
                'developers.*.name'       => 'required|string|max:255',
                'developers.*.logo_text'  => 'nullable|string|max:100',
                'developers.*.logo_dark'  => 'nullable|boolean',
                'developers.*.search_slug'=> 'nullable|string|max:100',
            ], [
                'developers.required' => 'Add at least one developer.',
                'developers.*.name.required' => 'Developer name is required.',
            ]);

            $section = FeaturedSection::create([
                'type'              => 'developers',
                'title'             => $validated['title'],
                'heading'           => $validated['heading'] ?? null,
                'heading_placement' => 'left',
                'sort_order'        => (int) ($request->input('sort_order', 0)),
                'is_active'         => $request->boolean('is_active', true),
            ]);

            foreach (array_values($request->input('developers', [])) as $i => $row) {
                if (empty($row['name'] ?? '')) {
                    continue;
                }
                $section->developers()->create([
                    'name'       => $row['name'],
                    'logo_text'  => $row['logo_text'] ?? null,
                    'logo_dark'  => ! empty($row['logo_dark']),
                    'search_slug'=> $row['search_slug'] ?? null,
                    'sort_order' => $i,
                ]);
            }

            return redirect()->route('admin.featured-sections.index')->with('success', 'Developers carousel created.');
        }

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
            'type'              => 'properties',
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
        $section = FeaturedSection::with(['properties', 'developers', 'images'])->findOrFail($id);
        $availableProperties = $this->getAvailableProperties($section->id);
        $selectedIds = $section->properties->pluck('id')->map(fn ($pid) => (int) $pid)->values()->toArray();
        return view('admin.featured-sections.edit', compact('section', 'availableProperties', 'selectedIds'));
    }

    public function update(Request $request, $id)
    {
        $section = FeaturedSection::with(['developers', 'images'])->findOrFail($id);

        if ($section->isImageCarouselType()) {
            $request->validate([
                'title'              => 'required|string|max:255',
                'heading_placement'  => 'required|string|in:left,right,center',
                'sort_order'         => 'nullable|integer|min:0',
                'is_active'          => 'nullable|boolean',
                'slides'             => 'required|array|min:1',
                'slides.*.image'     => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
                'slides.*.existing_image' => 'nullable|string|max:500',
                'slides.*.heading'   => 'nullable|string|max:255',
                'slides.*.second_heading' => 'nullable|string|max:255',
                'slides.*.heading_order'  => 'nullable|integer|in:1,2',
                'slides.*.cta_url'   => 'nullable|string|max:500',
                'slides.*.background_color' => 'nullable|string|max:20',
            ], [
                'slides.required' => 'Add at least one image slide.',
            ]);

            $section->update([
                'title'              => $request->input('title'),
                'heading_placement'  => $request->input('heading_placement', 'left'),
                'sort_order'         => (int) $request->input('sort_order', 0),
                'is_active'          => $request->boolean('is_active', true),
            ]);

            $section->images()->delete();
            foreach (array_values($request->input('slides', [])) as $i => $slide) {
                $imagePath = null;
                if ($request->hasFile('slides.' . $i . '.image')) {
                    $file = $request->file('slides.' . $i . '.image');
                    $name = Str::random(40) . '.' . $file->getClientOriginalExtension();
                    $file->move($this->carouselImagesStoragePath(), $name);
                    $imagePath = 'carousel-images/' . $name;
                } elseif (! empty($slide['existing_image'] ?? '')) {
                    $imagePath = $slide['existing_image'];
                }
                if ($imagePath) {
                    $section->images()->create([
                        'image_path'       => $imagePath,
                        'heading'          => $slide['heading'] ?? null,
                        'second_heading'   => $slide['second_heading'] ?? null,
                        'heading_order'    => (int) ($slide['heading_order'] ?? 1),
                        'cta_url'          => $slide['cta_url'] ?? null,
                        'background_color' => $this->normalizeColor($slide['background_color'] ?? null),
                        'sort_order'       => $i,
                    ]);
                }
            }

            return redirect()->route('admin.featured-sections.index')->with('success', 'Image carousel updated.');
        }

        if ($section->isDevelopersType()) {
            $validated = $request->validate([
                'title'      => 'required|string|max:255',
                'heading'    => 'nullable|string|max:500',
                'sort_order' => 'nullable|integer|min:0',
                'is_active'  => 'nullable|boolean',
                'developers' => 'required|array|min:1',
                'developers.*.name'       => 'required|string|max:255',
                'developers.*.logo_text'  => 'nullable|string|max:100',
                'developers.*.logo_dark'  => 'nullable|boolean',
                'developers.*.search_slug'=> 'nullable|string|max:100',
            ], [
                'developers.required' => 'Add at least one developer.',
                'developers.*.name.required' => 'Developer name is required.',
            ]);

            $section->update([
                'title'      => $validated['title'],
                'heading'    => $validated['heading'] ?? null,
                'sort_order'=> (int) ($request->input('sort_order', 0)),
                'is_active' => $request->boolean('is_active', true),
            ]);

            $section->developers()->delete();
            foreach (array_values($request->input('developers', [])) as $i => $row) {
                if (empty($row['name'] ?? '')) {
                    continue;
                }
                $section->developers()->create([
                    'name'       => $row['name'],
                    'logo_text'  => $row['logo_text'] ?? null,
                    'logo_dark'  => ! empty($row['logo_dark']),
                    'search_slug'=> $row['search_slug'] ?? null,
                    'sort_order' => $i,
                ]);
            }

            return redirect()->route('admin.featured-sections.index')->with('success', 'Developers carousel updated.');
        }

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
