<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Categories;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Akun demo
        User::updateOrCreate(
            ['email' => 'admin@mangkrak.io'],
            [
                'name' => 'admin123',
                'email' => 'admin@mangkrak.io',
                'password' => '123456',
                'role' => User::ROLE_ADMIN,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@mangkrak.io'],
            [
                'name' => 'user123',
                'email' => 'user@mangkrak.io',
                'password' => '123456',
                'role' => User::ROLE_USER,
                'email_verified_at' => now(),
            ]
        );

        // Kategori contoh
        $categories = [
            ['name' => 'Elektronik', 'slug' => 'elektronik', 'description' => 'Gadget dan perangkat elektronik', 'image' => 'https://picsum.photos/seed/elektronik/200/200'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'description' => 'Pakaian dan aksesoris gaya', 'image' => 'https://picsum.photos/seed/fashion/200/200'],
            ['name' => 'Makanan', 'slug' => 'makanan', 'description' => 'Makanan dan minuman segar', 'image' => 'https://picsum.photos/seed/makanan/200/200'],
            ['name' => 'Rumah Tangga', 'slug' => 'rumah-tangga', 'description' => 'Perlengkapan rumah tangga', 'image' => 'https://picsum.photos/seed/rumah/200/200'],
        ];

        foreach ($categories as $category) {
            Categories::updateOrCreate(['slug' => $category['slug']], $category);
        }

        // Produk contoh
        $products = [
            ['Headphone Wireless Pro', 'Headphone bluetooth dengan noise cancelling', 899000, 25, 'https://picsum.photos/seed/headphone/400/400', 'elektronik'],
            ['Smartwatch Series 9', 'Jam tangan pintar dengan GPS dan monitor jantung', 2499000, 8, 'https://picsum.photos/seed/watch/400/400', 'elektronik'],
            ['Kaos Polos Premium', 'Kaos katun combed 24s, nyaman dipakai', 85000, 120, 'https://picsum.photos/seed/kaos/400/400', 'fashion'],
            ['Jaket Hoodie Unisex', 'Hoodie fleece tebal untuk semua cuaca', 189000, 4, 'https://picsum.photos/seed/hoodie/400/400', 'fashion'],
            ['Kopi Arabika Gayo 250g', 'Kopi bubuk arabika premium asal Gayo', 65000, 60, 'https://picsum.photos/seed/kopi/400/400', 'makanan'],
            ['Sereal Granola 500g', 'Granola sehat dengan madu dan kacang', 78000, 15, 'https://picsum.photos/seed/granola/400/400', 'makanan'],
            ['Set Panci Stainless', 'Panci premium anti lengket 5 pcs', 420000, 30, 'https://picsum.photos/seed/panci/400/400', 'rumah-tangga'],
            ['Lampu Meja LED', 'Lampu meja LED dengan 3 mode cahaya', 145000, 3, 'https://picsum.photos/seed/lampu/400/400', 'rumah-tangga'],
        ];

        foreach ($products as $product) {
            $category = Categories::where('slug', $product[5])->first();

            Product::updateOrCreate(
                ['name' => $product[0]],
                [
                    'product_category_id' => $category?->id,
                    'name' => $product[0],
                    'description' => $product[1],
                    'price' => $product[2],
                    'stock' => $product[3],
                    'image' => $product[4],
                ]
            );
        }
    }
}
