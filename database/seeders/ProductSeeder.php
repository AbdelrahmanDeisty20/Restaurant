<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // مسح البيانات القديمة لتجنب التكرار
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\ProductExtra::truncate();
        \App\Models\ProductSize::truncate();
        Product::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $grillsId = Category::where('name_en', 'Grills')->first()?->id;
        $yemeniId = Category::where('name_en', 'Yemeni Dishes')->first()?->id;
        $appetizersId = Category::where('name_en', 'Appetizers')->first()?->id;
        $popularId = Category::where('name_en', 'Popular Dishes')->first()?->id;
        $dessertsId = Category::where('name_en', 'Desserts')->first()?->id;
        $beveragesId = Category::where('name_en', 'Beverages')->first()?->id;

        $products = [
            [
                'category_id' => $grillsId,
                'name_ar' => 'مشوي مشكل',
                'name_en' => 'Mix Grill',
                'description_ar' => 'تشكيلة من الكباب والكفتة والشيش طاووق مع الأرز',
                'description_en' => 'A variety of Kebab, Kofta, and Shish Tawook served with rice',
                'price' => 250.0,
                'discount_price' => 200.0,
                'main_image' => 'mix_grill.jpg',
                'is_active' => true,
                'is_featured' => true,
                'time' => '00:30',
                'included_extras' => 'سلطة خضراء، طحينة، عيش طازج',
                'sizes' => [
                    ['name_ar' => 'صغير', 'name_en' => 'Small', 'price' => 250.0],
                    ['name_ar' => 'وسط', 'name_en' => 'Medium', 'price' => 450.0],
                    ['name_ar' => 'كبير', 'name_en' => 'Large', 'price' => 650.0],
                ]
            ],
            [
                'category_id' => $grillsId,
                'name_ar' => 'كفتة مشوية',
                'name_en' => 'Grilled Kofta',
                'description_ar' => 'نصف كيلو كفتة لحم بلدي مع السلطات',
                'description_en' => 'Half kilo of local meat kofta with salads',
                'price' => 180.0,
                'discount_price' => 0,
                'main_image' => 'kofta.jpg',
                'is_active' => true,
                'is_featured' => false,
                'time' => '00:25',
                'included_extras' => 'طحينة، عيش، مخلل',
                'sizes' => [
                    ['name_ar' => 'نصف كيلو', 'name_en' => 'Half Kilo', 'price' => 180.0],
                    ['name_ar' => 'كيلو كامل', 'name_en' => 'Full Kilo', 'price' => 350.0],
                ]
            ],
            [
                'category_id' => $yemeniId,
                'name_ar' => 'مندي دجاج',
                'name_en' => 'Chicken Mandi',
                'description_ar' => 'دجاج مطهو على الطريقة اليمنية الأصلية في التنور',
                'description_en' => 'Chicken cooked in the authentic Yemeni way in a Tandoor',
                'price' => 120.0,
                'discount_price' => 110.0,
                'main_image' => 'mandi.jpg',
                'is_active' => true,
                'is_featured' => true,
                'time' => '01:00',
                'included_extras' => 'دقوس حار، مرق دجاج',
                'sizes' => [
                    ['name_ar' => 'ربع دجاجة', 'name_en' => 'Quarter Chicken', 'price' => 120.0],
                    ['name_ar' => 'نصف دجاجة', 'name_en' => 'Half Chicken', 'price' => 220.0],
                    ['name_ar' => 'دجاجة كاملة', 'name_en' => 'Full Chicken', 'price' => 400.0],
                ]
            ],
            [
                'category_id' => $popularId,
                'name_ar' => 'كشري مصري',
                'name_en' => 'Egyptian Koshary',
                'description_ar' => 'طبق الكشري المصري الشهير مع الصلصة والدقة',
                'description_en' => 'Famous Egyptian Koshary with tomato sauce and daqqa',
                'price' => 50.0,
                'discount_price' => 0,
                'main_image' => 'koshary.jpg',
                'is_active' => true,
                'is_featured' => true,
                'time' => '00:15',
                'included_extras' => 'صلصة، دقة، بصل مقرمش',
                'sizes' => [
                    ['name_ar' => 'صغير', 'name_en' => 'Small', 'price' => 50.0],
                    ['name_ar' => 'وسط', 'name_en' => 'Medium', 'price' => 70.0],
                    ['name_ar' => 'كبير', 'name_en' => 'Large', 'price' => 100.0],
                ]
            ],
            [
                'category_id' => $beveragesId,
                'name_ar' => 'ليمون نعناع',
                'name_en' => 'Lemon Mint',
                'description_ar' => 'عصير ليمون طازج مع النعناع المنعش',
                'description_en' => 'Fresh lemon juice with refreshing mint',
                'price' => 35.0,
                'discount_price' => 30.0,
                'main_image' => 'lemon_mint.jpg',
                'is_active' => true,
                'is_featured' => true,
                'time' => '00:05',
                'sizes' => [
                    ['name_ar' => 'كوب عادي', 'name_en' => 'Standard Cup', 'price' => 35.0],
                    ['name_ar' => 'لتر كامل', 'name_en' => 'Full Liter', 'price' => 90.0],
                ]
            ],
            [
                'category_id' => $appetizersId,
                'name_ar' => 'حمص',
                'name_en' => 'Hummus',
                'description_ar' => 'حمص بالطحينة وزيت الزيتون',
                'description_en' => 'Hummus with tahini and olive oil',
                'price' => 45.0,
                'discount_price' => 35.0,
                'main_image' => 'hummus.jpg',
                'is_active' => true,
                'is_featured' => false,
                'time' => '00:10',
                'sizes' => [
                    ['name_ar' => 'صغير', 'name_en' => 'Small', 'price' => 45.0],
                    ['name_ar' => 'كبير', 'name_en' => 'Large', 'price' => 80.0],
                ]
            ],
            [
                'category_id' => $appetizersId,
                'name_ar' => 'بابا غنوج',
                'name_en' => 'Baba Ghanoush',
                'description_ar' => 'باذنجان مشوي مع طحينة وخضروات',
                'description_en' => 'Grilled eggplant with tahini and vegetables',
                'price' => 45.0,
                'discount_price' => 0,
                'main_image' => 'baba_ghanoush.jpg',
                'is_active' => true,
                'is_featured' => false,
                'time' => '00:10',
                'sizes' => [
                    ['name_ar' => 'صغير', 'name_en' => 'Small', 'price' => 45.0],
                    ['name_ar' => 'كبير', 'name_en' => 'Large', 'price' => 80.0],
                ]
            ],
            [
                'category_id' => $dessertsId,
                'name_ar' => 'أرز بلبن',
                'name_en' => 'Rice Pudding',
                'description_ar' => 'أرز بلبن كريمي مع مكسرات',
                'description_en' => 'Creamy rice pudding with nuts',
                'price' => 40.0,
                'discount_price' => 0,
                'main_image' => 'rice_pudding.jpg',
                'is_active' => true,
                'is_featured' => false,
                'time' => '00:05',
                'sizes' => [
                    ['name_ar' => 'طبق عادي', 'name_en' => 'Standard Plate', 'price' => 40.0],
                    ['name_ar' => 'كيلو كامل', 'name_en' => 'Full Kilo', 'price' => 150.0],
                ]
            ],
        ];

        foreach ($products as $prodData) {
            $sizes = $prodData['sizes'] ?? [];
            unset($prodData['sizes']);

            $product = Product::create($prodData);

            foreach ($sizes as $size) {
                $product->sizes()->create($size);
            }
        }
    }
}
