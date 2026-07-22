<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Akun Admin
        User::create([
            'name' => 'Admin',
            'email' => 'adminproject@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // 2. Membuat Akun Pelanggan
        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'pelanggan',
        ]);

        // 3. Membuat Kategori Default
        Category::create([
            'nama' => 'Laptop', 
            'slug' => Str::slug('Laptop')
        ]);
        
        Category::create([
            'nama' => 'Aksesoris', 
            'slug' => Str::slug('Aksesoris')
        ]);
    }
}