<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerfumeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = \App\Models\Category::all();
        if ($categories->isEmpty()) {
            return;
        }

        $perfumes = [
            [
                'name' => 'Rose Water Cleanser',
                'brand' => 'ELAVA',
                'description' => 'A gentle, foaming rose water cleanser that removes impurities without stripping moisture.',
                'price' => 35.00,
                'image' => 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'stock' => 100,
                'category_id' => $categories->where('name', 'Cleansers')->first()?->id ?? $categories->first()->id,
            ],
            [
                'name' => 'Vitamin C Glow Serum',
                'brand' => 'ELAVA',
                'description' => 'A powerful antioxidant serum designed to brighten and even out skin tone.',
                'price' => 55.00,
                'image' => 'https://images.unsplash.com/photo-1620916297397-a4a5402a3c6c?q=80&w=800&auto=format&fit=crop',
                'stock' => 75,
                'category_id' => $categories->where('name', 'Serums')->first()?->id ?? $categories->first()->id,
            ],
            [
                'name' => 'Hydrating Cloud Cream',
                'brand' => 'ELAVA',
                'description' => 'A lightweight daily moisturizer featuring hyaluronic acid for deep, lasting hydration.',
                'price' => 48.00,
                'image' => 'https://images.unsplash.com/photo-1611078489935-0cb964de46d6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'stock' => 50,
                'category_id' => $categories->where('name', 'Moisturizers')->first()?->id ?? $categories->first()->id,
            ],
        ];

        foreach ($perfumes as $perfume) {
            \App\Models\Perfume::updateOrCreate(['name' => $perfume['name']], $perfume);
        }
    }
}
