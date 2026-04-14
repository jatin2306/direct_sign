<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeCtaSection;
use App\Models\HomeSalesSection;
use App\Models\HomeVerifiedSection;
use App\Models\HomeWhySection;
use Illuminate\Http\Request;

class HomeCtaSectionController extends Controller
{
    public function index()
    {
        $section = HomeCtaSection::query()->latest('id')->first();
        $verifiedSection = HomeVerifiedSection::query()->latest('id')->first();
        $whySection = HomeWhySection::query()->latest('id')->first();
        $salesSection = HomeSalesSection::query()->latest('id')->first();
        return view('admin.home-cta-sections.index', compact('section', 'verifiedSection', 'whySection', 'salesSection'));
    }

    public function create()
    {
        if (HomeCtaSection::query()->exists()) {
            return redirect()->route('admin.home-cta-sections.index')
                ->with('error', 'Only one Home CTA section is allowed. Edit the existing one.');
        }

        return view('admin.home-cta-sections.create');
    }

    public function store(Request $request)
    {
        if (HomeCtaSection::query()->exists()) {
            return redirect()->route('admin.home-cta-sections.index')
                ->with('error', 'Only one Home CTA section is allowed.');
        }

        $validated = $this->validateRequest($request);
        HomeCtaSection::create($validated);

        return redirect()->route('admin.home-cta-sections.index')->with('success', 'Home CTA section created.');
    }

    public function edit($id)
    {
        $section = HomeCtaSection::findOrFail($id);
        return view('admin.home-cta-sections.edit', compact('section'));
    }

    public function update(Request $request, $id)
    {
        $section = HomeCtaSection::findOrFail($id);
        $validated = $this->validateRequest($request);
        $section->update($validated);

        return redirect()->route('admin.home-cta-sections.index')->with('success', 'Home CTA section updated.');
    }

    public function destroy($id)
    {
        $section = HomeCtaSection::findOrFail($id);
        $section->delete();

        return redirect()->route('admin.home-cta-sections.index')->with('success', 'Home CTA section deleted.');
    }

    public function toggleActive($id)
    {
        $section = HomeCtaSection::findOrFail($id);
        $section->is_active = ! $section->is_active;
        $section->save();

        $status = $section->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.home-cta-sections.index')->with('success', "Home CTA section {$status}.");
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'primary_button_text' => 'nullable|string|max:100',
            'primary_button_url' => 'nullable|string|max:500',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_url' => 'nullable|string|max:500',
            'background_color' => 'nullable|string|max:20',
            'title_color' => 'nullable|string|max:20',
            'description_color' => 'nullable|string|max:20',
            'secondary_button_color' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ]) + [
            'is_active' => $request->boolean('is_active', true),
            'background_color' => $request->input('background_color') ?: '#e9f7f0',
            'title_color' => $request->input('title_color') ?: '#26AE61',
            'description_color' => $request->input('description_color') ?: '#4A225B',
            'secondary_button_color' => $request->input('secondary_button_color') ?: '#26AE61',
        ];
    }
}
