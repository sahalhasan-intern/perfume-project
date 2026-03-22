<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@elava.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        // Demo user
        User::create([
            'name' => 'Demo User',
            'email' => 'user@elava.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Run CategorySeeder
        $this->call(CategorySeeder::class);

        $faceWashCat = Category::where('name', 'Face Wash')->first();
        $serumCat = Category::where('name', 'Serum')->first();
        $moisturizerCat = Category::where('name', 'Moisturizer')->first();

        // Products

        $products = [
            [
                'name' => 'Elava Gentle Hydrating Cleanser',
                'category_id' => $faceWashCat->id,
                'description' => 'A gentle, foaming cleanser that removes impurities without stripping moisture.',
                'price' => 25.00,
                'stock' => 100,
                'ingredients' => 'Aqua, Glycerin, Ceramides',
                'benefits' => 'Hydrates, Gentle on skin',
                'image' => 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Vitamin C Glow Serum',
                'category_id' => $serumCat->id,
                'description' => 'A powerful antioxidant serum designed to brighten and even out skin tone.',
                'price' => 45.00,
                'stock' => 50,
                'ingredients' => 'Vitamin C, Hyaluronic Acid',
                'benefits' => 'Brightens, Evens tone',
                'image' => 'https://images.unsplash.com/photo-1620916297397-a4a5402a3c6c?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Lightweight Cloud Moisturizer',
                'category_id' => $moisturizerCat->id,
                'description' => 'A lightweight daily moisturizer featuring hyaluronic acid for deep, lasting hydration.',
                'price' => 38.00,
                'stock' => 75,
                'ingredients' => 'Hyaluronic Acid, Squalane',
                'benefits' => 'Deep hydration, Non-greasy',
                'image' => 'https://images.unsplash.com/photo-1611078489935-0cb964de46d6?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Purifying Clay Cleanser',
                'category_id' => $faceWashCat->id,
                'description' => 'A deep-cleaning clay formula that visibly minimizes pores.',
                'price' => 22.00,
                'stock' => 120,
                'ingredients' => 'Kaolin Clay, Niacinamide',
                'benefits' => 'Minimizes pores, Removes excess oil',
                'image' => 'https://images.unsplash.com/photo-1570554886111-e80fcca6a029?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Night Repair Serum',
                'category_id' => $serumCat->id,
                'description' => 'Advanced night repair serum to rebuild your skin\'s barrier while you sleep.',
                'price' => 55.00,
                'stock' => 45,
                'ingredients' => 'Peptides, Retinol',
                'benefits' => 'Anti-aging, Improves texture',
                'image' => 'https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Rich Recovery Cream',
                'category_id' => $moisturizerCat->id,
                'description' => 'Intense moisture cream for dry, compromised skin barriers.',
                'price' => 42.00,
                'stock' => 80,
                'ingredients' => 'Shea Butter, Ceramides, Oat Extract',
                'benefits' => 'Intense hydration, Soothes redness',
                'image' => 'https://images.unsplash.com/photo-1555820585-c5ae44394b79?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'BHA Exfoliating Cleanser',
                'category_id' => $faceWashCat->id,
                'description' => 'Salicylic acid cleanser that penetrates pores to clear blemishes.',
                'price' => 28.00,
                'stock' => 95,
                'ingredients' => '2% Salicylic Acid, Green Tea',
                'benefits' => 'Clears blemishes, Unclogs pores',
                'image' => 'https://images.unsplash.com/photo-1580870059781-bc015fbe8eb6?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Hyaluronic Acid Booster',
                'category_id' => $serumCat->id,
                'description' => 'Pure plumping booster that draws moisture deep into the skin.',
                'price' => 35.00,
                'stock' => 110,
                'ingredients' => 'Sodium Hyaluronate, Panthenol',
                'benefits' => 'Plumps fine lines, Instant hydration',
                'image' => 'https://images.unsplash.com/photo-1550831107-1553da8c8464?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Daily Defense Lotion',
                'category_id' => $moisturizerCat->id,
                'description' => 'Daily moisturizer with antioxidant protection and a lightweight finish.',
                'price' => 34.00,
                'stock' => 85,
                'ingredients' => 'Vitamin E, Aloe Vera',
                'benefits' => 'Daily protection, Fast-absorbing',
                'image' => 'https://images.unsplash.com/photo-1556228720-192b61ccb8ca?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Rosewater Soothing Mist Serum',
                'category_id' => $serumCat->id,
                'description' => 'A misty spritz serum layered with rosewater and collagen for an instant glow.',
                'price' => 30.00,
                'stock' => 60,
                'ingredients' => 'Rosewater, Collagen',
                'benefits' => 'Instantly refreshes, Sets makeup',
                'image' => 'https://images.unsplash.com/photo-1599305090598-fe179d501227?auto=format&fit=crop&w=800&q=80',
            ]
        ];


        foreach ($products as $prod) {
            $prod['slug'] = Str::slug($prod['name']);
            Product::create($prod);
        }
    }
}
