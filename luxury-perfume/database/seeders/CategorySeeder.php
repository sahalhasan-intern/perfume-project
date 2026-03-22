<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Skin Treatment Categories
            ['name' => 'Anti-Aging', 'slug' => 'anti-aging'],
            ['name' => 'Pigmentation', 'slug' => 'pigmentation'],
            ['name' => 'Dark Spots', 'slug' => 'dark-spots'],
            ['name' => 'Pimple Removal', 'slug' => 'pimple-removal'],
            ['name' => 'Scar Treatment', 'slug' => 'scar-treatment'],
            ['name' => 'Sun Protection', 'slug' => 'sun-protection'],

            // Product Type Categories
            ['name' => 'Face Wash', 'slug' => 'face-wash'],
            ['name' => 'Moisturizer', 'slug' => 'moisturizer'],
            ['name' => 'Serum', 'slug' => 'serum'],
            ['name' => 'Sunscreen', 'slug' => 'sunscreen'],
            ['name' => 'Toner', 'slug' => 'toner'],
            ['name' => 'Night Cream', 'slug' => 'night-cream'],
            ['name' => 'Day Cream', 'slug' => 'day-cream'],
            ['name' => 'Eye Cream', 'slug' => 'eye-cream'],

            // Special Categories
            ['name' => 'Men Skincare', 'slug' => 'men-skincare'],
            ['name' => 'Women Skincare', 'slug' => 'women-skincare'],
            ['name' => 'Organic Products', 'slug' => 'organic-products'],
            ['name' => 'Dermatologist Recommended', 'slug' => 'dermatologist-recommended'],
            ['name' => 'Best Sellers', 'slug' => 'best-sellers'],
            ['name' => 'New Arrivals', 'slug' => 'new-arrivals'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}

