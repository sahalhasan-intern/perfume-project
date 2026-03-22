<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('secretpassword'), // Default test password
            'role' => 'admin',
        ]);
        
        User::create([
            'name' => 'Demo Customer',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('secretpassword'), // Default test password
            'role' => 'customer',
        ]);
    }
}
