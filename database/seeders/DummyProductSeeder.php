<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Database\Seeder;

class DummyProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // مسح المنتجات والأحجام القديمة
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\ProductExtra::truncate();
        \App\Models\ProductSize::truncate();
        Product::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 1. Create 100 products with discount_price and NO sizes
        Product::factory()->count(100)->create([
            'discount_price' => function (array $attributes) {
                return $attributes['price'] * 0.8;
            }
        ]);

        // 2. Create 100 products with NO discount_price and 2-3 sizes each
        Product::factory()->count(100)->create([
            'discount_price' => null
        ])->each(function ($product) {
            $numberOfSizes = rand(2, 3);
            for ($i = 1; $i <= $numberOfSizes; $i++) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'name_ar' => 'حجم ' . $i,
                    'name_en' => 'Size ' . $i,
                    'price' => $product->price + ($i * 10),
                ]);
            }
        });
    }
}
