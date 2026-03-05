<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        ProductImage::truncate();

        $imageNames = [
            'mix_grill' => ['mix_grill_1.jpg', 'mix_grill_2.jpg', 'mix_grill_3.jpg', 'mix_grill_4.jpg'],
            'kofta' => ['kofta_1.jpg', 'kofta_2.jpg', 'kofta_3.jpg', 'kofta_4.jpg'],
            'mandi' => ['mandi_1.jpg', 'mandi_2.jpg', 'mandi_3.jpg', 'mandi_4.jpg'],
            'madhbi' => ['madhbi_1.jpg', 'madhbi_2.jpg', 'madhbi_3.jpg', 'madhbi_4.jpg'],
            'hummus' => ['hummus_1.jpg', 'hummus_2.jpg', 'hummus_3.jpg', 'hummus_4.jpg'],
            'tabbouleh' => ['tabbouleh_1.jpg', 'tabbouleh_2.jpg', 'tabbouleh_3.jpg', 'tabbouleh_4.jpg'],
            'koshary' => ['koshary_1.jpg', 'koshary_2.jpg', 'koshary_3.jpg', 'koshary_4.jpg'],
            'kunafa' => ['kunafa_1.jpg', 'kunafa_2.jpg', 'kunafa_3.jpg', 'kunafa_4.jpg'],
            'orange_juice' => ['orange_juice_1.jpg', 'orange_juice_2.jpg', 'orange_juice_3.jpg', 'orange_juice_4.jpg'],
        ];

        $products = Product::all();

        foreach ($products as $index => $product) {
            // نختار مجموعة الصور المناسبة للمنتج أو نعمل صور افتراضية
            $keys = array_keys($imageNames);
            $key = $keys[$index % count($keys)];
            $images = $imageNames[$key];

            foreach ($images as $sort => $imageName) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'images' => $imageName,
                    'sort' => $sort + 1,
                ]);
            }
        }
    }
}
