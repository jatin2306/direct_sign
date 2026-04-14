<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        if (Schema::hasTable('home_cta_sections') && ! DB::table('home_cta_sections')->exists()) {
            DB::table('home_cta_sections')->insert([
                'title' => 'Buy, Sell & Rent Verified Properties in Dubai - Lowest Brokerage Fees',
                'description' => "Be Direct, Be Intelligent - Dubai's most transparent, RERA-licensed real estate platform.\nNo inflated commissions. No fake listings. Just verified, direct property deals.",
                'primary_button_text' => 'Search Verified Properties',
                'primary_button_url' => url('properties'),
                'secondary_button_text' => 'List Your Property Free',
                'secondary_button_url' => url('add-listing'),
                'background_color' => '#e9f7f0',
                'title_color' => '#26AE61',
                'description_color' => '#4A225B',
                'secondary_button_color' => '#26AE61',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        if (Schema::hasTable('home_verified_sections') && ! DB::table('home_verified_sections')->exists()) {
            $cards = [
                [
                    'title' => 'Ownership Documents Checked',
                    'description' => 'We ensure the property is legally owned by the advertiser.',
                ],
                [
                    'title' => 'Landlord Identity Verified',
                    'description' => 'No fake agents. Only real owners and real landlords.',
                ],
                [
                    'title' => 'Property Details Validated',
                    'description' => 'Photos, size, location, and specs are inspected for accuracy.',
                ],
                [
                    'title' => 'In-Person Review When Needed',
                    'description' => 'We perform site visits when necessary to ensure authenticity.',
                ],
            ];

            DB::table('home_verified_sections')->insert([
                'heading' => '100% Verified Listings - No Fake Ads, No Time Wasters',
                'intro_text' => 'Every property on Direct Deal UAE goes through strict verification:',
                'cards' => json_encode($cards),
                'item_1_title' => 'Ownership Documents Checked',
                'item_1_description' => 'We ensure the property is legally owned by the advertiser.',
                'item_2_title' => 'Landlord Identity Verified',
                'item_2_description' => 'No fake agents. Only real owners and real landlords.',
                'item_3_title' => 'Property Details Validated',
                'item_3_description' => 'Photos, size, location, and specs are inspected for accuracy.',
                'item_4_title' => 'In-Person Review When Needed',
                'item_4_description' => 'We perform site visits when necessary to ensure authenticity.',
                'footer_text' => 'No duplicates. No misleading ads. Only real, verified Dubai properties.',
                'heading_color' => '#26AE61',
                'text_color' => '#4A225B',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        if (Schema::hasTable('home_why_sections') && ! DB::table('home_why_sections')->exists()) {
            $cards = [
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

            DB::table('home_why_sections')->insert([
                'heading' => 'Why Direct Deal UAE?',
                'background_color' => '#f7fdfb',
                'heading_color' => '#26AE61',
                'cards' => json_encode($cards),
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        if (Schema::hasTable('home_sales_sections') && ! DB::table('home_sales_sections')->exists()) {
            $steps = [
                [
                    'title' => 'Owner Lists Property (Free)',
                    'description' => 'Upload photos & details - our team verifies ownership before going live.',
                ],
                [
                    'title' => 'Buyer Shows Interest',
                    'description' => 'Buyer contacts through Direct Deal -> we verify ID & financial capability.',
                ],
                [
                    'title' => 'Direct Connection & Secure Offer Exchange',
                    'description' => 'Verified offers are shared safely. Direct Deal acts as a RERA-licensed brokerage, facilitating negotiations, contracts, and transaction completion.',
                ],
            ];

            DB::table('home_sales_sections')->insert([
                'heading' => 'How Direct Deal Works -',
                'heading_highlight' => 'Property Sales',
                'section_background_color' => '#ffffff',
                'heading_color' => '#26AE61',
                'heading_highlight_color' => '#4A225B',
                'box_background_color' => '#f7fdfb',
                'box_border_color' => '#26AE61',
                'step_title_color' => '#26AE61',
                'steps' => json_encode($steps),
                'bottom_note' => 'Buyers pay only 0.2% brokerage - compared to the market standard of 2%.',
                'bottom_note_prefix' => 'Buyers pay only ',
                'bottom_note_highlight' => '0.2% brokerage',
                'bottom_note_suffix' => ' - compared to the market standard of 2%.',
                'bottom_note_text_color' => '#212529',
                'bottom_note_highlight_color' => '#26AE61',
                'bottom_note_subtext' => 'This covers documentation, verification, contract A, B, F preparation and support until property transfer.',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        // Intentionally left blank. This migration seeds defaults only when missing.
    }
};
