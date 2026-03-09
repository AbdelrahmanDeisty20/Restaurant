<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Database\Seeder;

class ProductSizeSeeder extends Seeder
{
    public function run(): void
    {
        ProductSize::truncate();

        $sizes = [
            // مشوي مشكل
            'Mix Grill' => [
                ['name_ar' => 'حصة فردية', 'name_en' => 'Single', 'price' => 250.0],
                ['name_ar' => 'حصة مزدوجة', 'name_en' => 'Double', 'price' => 450.0],
                ['name_ar' => 'عائلي', 'name_en' => 'Family', 'price' => 750.0],
            ],
            // كفتة مشوية
            'Grilled Kofta' => [
                ['name_ar' => 'ربع كيلو', 'name_en' => 'Quarter KG', 'price' => 100.0],
                ['name_ar' => 'نصف كيلو', 'name_en' => 'Half KG', 'price' => 180.0],
                ['name_ar' => 'كيلو', 'name_en' => 'One KG', 'price' => 340.0],
            ],
            // شيش طاووق
            'Shish Tawook' => [
                ['name_ar' => 'صغير', 'name_en' => 'Small', 'price' => 100.0],
                ['name_ar' => 'وسط', 'name_en' => 'Medium', 'price' => 160.0],
                ['name_ar' => 'كبير', 'name_en' => 'Large', 'price' => 250.0],
            ],
            // مندي دجاج
            'Chicken Mandi' => [
                ['name_ar' => 'ربع دجاجة', 'name_en' => 'Quarter Chicken', 'price' => 65.0],
                ['name_ar' => 'نصف دجاجة', 'name_en' => 'Half Chicken', 'price' => 120.0],
                ['name_ar' => 'دجاجة كاملة', 'name_en' => 'Full Chicken', 'price' => 220.0],
            ],
            // لحم حنيذ
            'Meat Haneeth' => [
                ['name_ar' => 'ربع كيلو', 'name_en' => 'Quarter KG', 'price' => 120.0],
                ['name_ar' => 'نصف كيلو', 'name_en' => 'Half KG', 'price' => 220.0],
                ['name_ar' => 'كيلو', 'name_en' => 'One KG', 'price' => 400.0],
            ],
            // كنافة نابلسية
            'Nabulsi Kunafa' => [
                ['name_ar' => 'قطعة', 'name_en' => 'Slice', 'price' => 30.0],
                ['name_ar' => 'نصف كيلو', 'name_en' => 'Half KG', 'price' => 80.0],
                ['name_ar' => 'كيلو', 'name_en' => 'One KG', 'price' => 150.0],
            ],
        ];

        foreach ($sizes as $productNameEn => $productSizes) {
            $product = Product::where('name_en', $productNameEn)->first();
            if ($product) {
                foreach ($productSizes as $size) {
                    $product->sizes()->create($size);
                }
            }
        }
    }
}
