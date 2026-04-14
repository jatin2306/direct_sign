<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeVerifiedSection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HomeVerifiedSectionController extends Controller
{
    private function defaultCards(): array
    {
        return [
            ['title' => 'Ownership Documents Checked', 'description' => 'We ensure the property is legally owned by the advertiser.'],
            ['title' => 'Landlord Identity Verified', 'description' => 'No fake agents. Only real owners and real landlords.'],
            ['title' => 'Property Details Validated', 'description' => 'Photos, size, location, and specs are inspected for accuracy.'],
            ['title' => 'In-Person Review When Needed', 'description' => 'We perform site visits when necessary to ensure authenticity.'],
        ];
    }

    private function normalizeCards(Request $request): array
    {
        $cards = $request->input('cards', []);
        if (! is_array($cards)) {
            $cards = [];
        }

        $normalized = [];
        foreach ($cards as $card) {
            $title = trim((string) ($card['title'] ?? ''));
            $description = trim((string) ($card['description'] ?? ''));
            if ($title === '' && $description === '') {
                continue;
            }
            $normalized[] = [
                'title' => $title,
                'description' => $description,
            ];
        }

        return $normalized;
    }

    public function create()
    {
        if (HomeVerifiedSection::query()->exists()) {
            return redirect()->route('admin.home-cta-sections.index')
                ->with('error', 'Only one Verified Listings section is allowed. Edit the existing one.');
        }

        return view('admin.home-verified-sections.create', [
            'defaultCards' => $this->defaultCards(),
        ]);
    }

    public function store(Request $request)
    {
        if (HomeVerifiedSection::query()->exists()) {
            return redirect()->route('admin.home-cta-sections.index')
                ->with('error', 'Only one Verified Listings section is allowed.');
        }

        $validated = $this->validateRequest($request);
        HomeVerifiedSection::create($validated);

        return redirect()->route('admin.home-cta-sections.index')->with('success', 'Verified Listings section created.');
    }

    public function edit($id)
    {
        $section = HomeVerifiedSection::findOrFail($id);
        $cards = is_array($section->cards) && ! empty($section->cards) ? $section->cards : $this->defaultCards();
        return view('admin.home-verified-sections.edit', compact('section', 'cards'));
    }

    public function update(Request $request, $id)
    {
        $section = HomeVerifiedSection::findOrFail($id);
        $validated = $this->validateRequest($request);
        $section->update($validated);

        return redirect()->route('admin.home-cta-sections.index')->with('success', 'Verified Listings section updated.');
    }

    public function destroy($id)
    {
        $section = HomeVerifiedSection::findOrFail($id);
        $section->delete();

        return redirect()->route('admin.home-cta-sections.index')->with('success', 'Verified Listings section deleted.');
    }

    public function toggleActive($id)
    {
        $section = HomeVerifiedSection::findOrFail($id);
        $section->is_active = ! $section->is_active;
        $section->save();

        $status = $section->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.home-cta-sections.index')->with('success', "Verified Listings section {$status}.");
    }

    private function validateRequest(Request $request): array
    {
        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'intro_text' => 'nullable|string|max:1000',
            'cards' => 'required|array|min:1',
            'cards.*.title' => 'nullable|string|max:255',
            'cards.*.description' => 'nullable|string|max:1000',
            'item_1_title' => 'nullable|string|max:255',
            'item_1_description' => 'nullable|string|max:1000',
            'item_2_title' => 'nullable|string|max:255',
            'item_2_description' => 'nullable|string|max:1000',
            'item_3_title' => 'nullable|string|max:255',
            'item_3_description' => 'nullable|string|max:1000',
            'item_4_title' => 'nullable|string|max:255',
            'item_4_description' => 'nullable|string|max:1000',
            'footer_text' => 'nullable|string|max:1000',
            'heading_color' => 'nullable|string|max:20',
            'text_color' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ]);

        $cards = $this->normalizeCards($request);
        if (empty($cards)) {
            throw ValidationException::withMessages([
                'cards' => 'Please add at least one card with title or description.',
            ]);
        }

        return $validated + [
            'cards' => $cards,
            'is_active' => $request->boolean('is_active', true),
            'heading_color' => $request->input('heading_color') ?: '#26AE61',
            'text_color' => $request->input('text_color') ?: '#4A225B',
        ];
    }
}
