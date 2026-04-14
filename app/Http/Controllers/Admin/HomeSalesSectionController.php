<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSalesSection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HomeSalesSectionController extends Controller
{
    private function defaultSteps(): array
    {
        return [
            ['title' => 'Owner Lists Property (Free)', 'description' => 'Upload photos & details — our team verifies ownership before going live.'],
            ['title' => 'Buyer Shows Interest', 'description' => 'Buyer contacts through Direct Deal -> we verify ID & financial capability.'],
            ['title' => 'Direct Connection & Secure Offer Exchange', 'description' => 'Verified offers are shared safely. Direct Deal acts as a RERA-licensed brokerage, facilitating negotiations, contracts, and transaction completion.'],
        ];
    }

    private function normalizeSteps(Request $request): array
    {
        $steps = $request->input('steps', []);
        if (! is_array($steps)) {
            $steps = [];
        }
        $normalized = [];
        foreach ($steps as $step) {
            $title = trim((string) ($step['title'] ?? ''));
            $description = trim((string) ($step['description'] ?? ''));
            if ($title === '' && $description === '') {
                continue;
            }
            $normalized[] = ['title' => $title, 'description' => $description];
        }
        return $normalized;
    }

    public function create()
    {
        if (HomeSalesSection::query()->exists()) {
            return redirect()->route('admin.home-cta-sections.index')->with('error', 'Only one Property Sales section is allowed.');
        }
        return view('admin.home-sales-sections.create', ['defaultSteps' => $this->defaultSteps()]);
    }

    public function store(Request $request)
    {
        if (HomeSalesSection::query()->exists()) {
            return redirect()->route('admin.home-cta-sections.index')->with('error', 'Only one Property Sales section is allowed.');
        }
        HomeSalesSection::create($this->validateRequest($request));
        return redirect()->route('admin.home-cta-sections.index')->with('success', 'Property Sales section created.');
    }

    public function edit($id)
    {
        $section = HomeSalesSection::findOrFail($id);
        $steps = is_array($section->steps) && ! empty($section->steps) ? $section->steps : $this->defaultSteps();
        return view('admin.home-sales-sections.edit', compact('section', 'steps'));
    }

    public function update(Request $request, $id)
    {
        $section = HomeSalesSection::findOrFail($id);
        $section->update($this->validateRequest($request));
        return redirect()->route('admin.home-cta-sections.index')->with('success', 'Property Sales section updated.');
    }

    public function destroy($id)
    {
        HomeSalesSection::findOrFail($id)->delete();
        return redirect()->route('admin.home-cta-sections.index')->with('success', 'Property Sales section deleted.');
    }

    public function toggleActive($id)
    {
        $section = HomeSalesSection::findOrFail($id);
        $section->is_active = ! $section->is_active;
        $section->save();
        $status = $section->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.home-cta-sections.index')->with('success', "Property Sales section {$status}.");
    }

    private function validateRequest(Request $request): array
    {
        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'heading_highlight' => 'nullable|string|max:255',
            'section_background_color' => 'nullable|string|max:20',
            'heading_color' => 'nullable|string|max:20',
            'heading_highlight_color' => 'nullable|string|max:20',
            'box_background_color' => 'nullable|string|max:20',
            'box_border_color' => 'nullable|string|max:20',
            'step_title_color' => 'nullable|string|max:20',
            'steps' => 'required|array|min:1',
            'steps.*.title' => 'nullable|string|max:255',
            'steps.*.description' => 'nullable|string|max:2000',
            'bottom_note' => 'nullable|string|max:2000',
            'bottom_note_prefix' => 'nullable|string|max:500',
            'bottom_note_highlight' => 'nullable|string|max:500',
            'bottom_note_suffix' => 'nullable|string|max:500',
            'bottom_note_text_color' => 'nullable|string|max:20',
            'bottom_note_highlight_color' => 'nullable|string|max:20',
            'bottom_note_subtext' => 'nullable|string|max:2000',
            'is_active' => 'nullable|boolean',
        ]);

        $steps = $this->normalizeSteps($request);
        if (empty($steps)) {
            throw ValidationException::withMessages(['steps' => 'Please add at least one step.']);
        }

        return $validated + [
            'steps' => $steps,
            'section_background_color' => $request->input('section_background_color') ?: '#ffffff',
            'heading_color' => $request->input('heading_color') ?: '#26AE61',
            'heading_highlight_color' => $request->input('heading_highlight_color') ?: '#4A225B',
            'box_background_color' => $request->input('box_background_color') ?: '#f7fdfb',
            'box_border_color' => $request->input('box_border_color') ?: '#26AE61',
            'step_title_color' => $request->input('step_title_color') ?: '#26AE61',
            'bottom_note_text_color' => $request->input('bottom_note_text_color') ?: '#212529',
            'bottom_note_highlight_color' => $request->input('bottom_note_highlight_color') ?: '#26AE61',
            'is_active' => $request->boolean('is_active', true),
        ];
    }
}
