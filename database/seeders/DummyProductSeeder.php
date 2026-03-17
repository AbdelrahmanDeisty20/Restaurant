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
        // مسح البيانات القديمة لضمان نظافة الاختبار
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\ProductExtra::truncate();
        \App\Models\ProductSize::truncate();
        Product::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // إنشاء بعض الإضافات أولاً
        $extras = [];
        for ($i = 1; $i <= 5; $i++) {
            $extras[] = \App\Models\ProductExtra::create([
                'name_ar' => 'إضافة ' . $i,
                'name_en' => 'Extra ' . $i,
                'price' => rand(10, 50),
            ]);
        }
        $extrasIds = collect($extras)->pluck('id')->toArray();

        // 1. Create 50 products with discount_price and NO sizes or extras
        Product::factory()->count(50)->create([
            'discount_price' => function (array $attributes) {
                return $attributes['price'] * 0.8;
            },
            'included_extras' => null
        ]);

        // 2. Create 50 products with NO discount_price, price = 0, and 2-3 sizes each
        Product::factory()->count(50)->create([
            'discount_price' => null,
            'price' => 0,
            'included_extras' => null
        ])->each(function ($product) {
            $numberOfSizes = rand(2, 3);
            for ($i = 1; $i <= $numberOfSizes; $i++) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'name_ar' => 'حجم ' . $i,
                    'name_en' => 'Size ' . $i,
                    'price' => rand(150, 300),
                ]);
            }
        });

        // 3. Create 50 products with extras, sizes, and price = 0
        Product::factory()->count(50)->create([
            'discount_price' => null,
            'price' => 0,
            'included_extras' => json_encode(array_slice($extrasIds, 0, rand(1, 4)))
        ])->each(function ($product) {
            $numberOfSizes = rand(2, 3);
            for ($i = 1; $i <= $numberOfSizes; $i++) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'name_ar' => 'حجم ' . $i,
                    'name_en' => 'Size ' . $i,
                    'price' => rand(150, 300),
                ]);
            }
        });
    }
}
