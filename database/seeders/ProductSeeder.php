<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Game PS5 - Example Game',
            'description' => 'Deskripsi untuk Game PS5.',
            'price' => 5000,
            'image_url' => 'https://example.com/image1.jpg',
            'category_id' => 1,
        ]);

        Product::create([
            'name' => 'Game PC - Example Game',
            'description' => 'Deskripsi untuk Game PC.',
            'price' => 3000,
            'image_url' => 'https://example.com/image2.jpg',
            'category_id' => 2,
        ]);
    }   
}
