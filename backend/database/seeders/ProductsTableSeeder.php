<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Samsung Galaxy S23 Ultra',
                'price' => 1199.99,
                'display_image' => 'https://www.phoneplacekenya.com/wp-content/uploads/2022/06/Samsung-Galaxy-S23-5G-a.jpg',
                'description' => 'Samsung Galaxy S23 Ultra with 256GB storage, 8GB RAM, and a 200MP camera. Perfect for photography and high-performance tasks.',
            ],
            [
                'name' => 'Apple MacBook Pro 16"',
                'price' => 2499.99,
                'display_image' => 'https://mac-more.co.ke/wp-content/uploads/2021/11/macbook-pro-m1-pro-16-inch-1-e1718368409875.jpg',
                'description' => 'Apple MacBook Pro 16-inch with M2 Pro chip, 16GB RAM, and 512GB SSD. Sleek design and incredible performance for professionals.',
            ],
            [
                'name' => 'Sony WH-1000XM5 Headphones',
                'price' => 399.99,
               'display_image'=>'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/09/1605502/1.jpg?0497',
                'description' => 'Sony WH-1000XM5 wireless noise-canceling headphones with 30-hour battery life. Immerse yourself in high-quality audio.',
            ],
            [
                'name' => 'LG 55" OLED 4K Smart TV',
                'price' => 1299.99,
                'display_image' => 'https://overtech.co.ke/wp-content/uploads/2024/02/Untitled-design-9-1.png',
                'description' => 'LG 55-inch OLED 4K Smart TV with AI ThinQ, Dolby Vision, and built-in Google Assistant. Stunning visuals and smart features for your living room.',
            ],
            [
                'name' => 'Logitech MX Master 3 Mouse',
                'price' => 99.99,
                'display_image' => 'https://www.digitalstore.co.ke/cdn/shop/products/MX1_600x.jpg?v=1623747854',
                'description' => 'Logitech MX Master 3 Advanced Wireless Mouse with ultra-fast scrolling, customizable buttons, and ergonomic design for productivity.',
            ],
        ]);
    
    }
}
