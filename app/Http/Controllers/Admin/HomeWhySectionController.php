<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeWhySection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HomeWhySectionController extends Controller
{
    private function defaultCards(): array
    {
        return [
            [
                'title' => '0% Commission for Owners & Landlords',
                'description' => 'No brokerage charged to sellers or landlords. Listing your property is completely free.',
            ],
            [
                'title' => 'Lowest Brokerage Fees in the UAE',
                'description' => 'Buyers pay only 0.2% brokerage and tenants pay 0.5% brokerage. Traditional brokers charge 2%-5%.',
            ],
            [
                'title' => 'Verified Owners, Buyers & Tenants',
                'description' => 'No fake leads or misleading ads. All users are identity-verified before connecting.',
            ],
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
        if (HomeWhySection::query()->exists()) {
            return redirect()->route('admin.home-cta-sections.index')
                ->with('error', 'Only one Why Direct Deal section is allowed. Edit the existing one.');
        }

        return view('admin.home-why-sections.create', [
            'defaultCards' => $this->defaultCards(),
        ]);
    }

    public function store(Request $request)
    {
        if (HomeWhySection::query()->exists()) {
            return redirect()->route('admin.home-cta-sections.index')
                ->with('error', 'Only one Why Direct Deal section is allowed.');
        }

        $validated = $this->validateRequest($request);
        HomeWhySection::create($validated);

        return redirect()->route('admin.home-cta-sections.index')->with('success', 'Why Direct Deal section created.');
    }

    public function edit($id)
    {
        $section = HomeWhySection::findOrFail($id);
        $cards = is_array($section->cards) && ! empty($section->cards) ? $section->cards : $this->defaultCards();
        return view('admin.home-why-sections.edit', compact('section', 'cards'));
    }

    public function update(Request $request, $id)
    {
        $section = HomeWhySection::findOrFail($id);
        $validated = $this->validateRequest($request);
        $section->update($validated);

        return redirect()->route('admin.home-cta-sections.index')->with('success', 'Why Direct Deal section updated.');
    }

    public function destroy($id)
    {
        $section = HomeWhySection::findOrFail($id);
        $section->delete();

        return redirect()->route('admin.home-cta-sections.index')->with('success', 'Why Direct Deal section deleted.');
    }

    public function toggleActive($id)
    {
        $section = HomeWhySection::findOrFail($id);
        $section->is_active = ! $section->is_active;
        $section->save();

        $status = $section->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.home-cta-sections.index')->with('success', "Why Direct Deal section {$status}.");
    }

    private function validateRequest(Request $request): array
    {
        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'background_color' => 'nullable|string|max:20',
            'heading_color' => 'nullable|string|max:20',
            'cards' => 'required|array|min:1',
            'cards.*.title' => 'nullable|string|max:255',
            'cards.*.description' => 'nullable|string|max:1000',
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
            'background_color' => $request->input('background_color') ?: '#f7fdfb',
            'heading_color' => $request->input('heading_color') ?: '#26AE61',
            'is_active' => $request->boolean('is_active', true),
        ];
    }
}
