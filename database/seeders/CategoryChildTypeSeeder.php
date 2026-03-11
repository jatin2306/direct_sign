<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryChildTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define categories and their child types
        $data = [
            'Residential' => ['Apartment', 'Villa', 'Townhouse', 'Penthouse'],
            'Commercial' => ['Office', 'Shop', 'Warehouse', 'Showroom'],
            'Industrial' => ['Factory', 'Warehouse', 'Industrial Land'],
            'Land' => ['Agricultural Land', 'Commercial Land', 'Residential Land'],
        ];

        foreach ($data as $categoryName => $childTypes) {
            // Insert category
            $categoryId = DB::table('categories')->insertGetId(['name' => $categoryName, 'created_at' => now(), 'updated_at' => now()]);

            // Insert child types
            foreach ($childTypes as $childTypeName) {
                DB::table('child_types')->insert([
                    'category_id' => $categoryId,
                    'name' => $childTypeName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
