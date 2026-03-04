<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
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
                'price' => 250.00,
                'main_image' => 'mix_grill.jpg',
                'is_active' => true,
                'is_featured' => true,
                'extras' => [
                    ['name_ar' => 'بطاطس مقلية', 'name_en' => 'French Fries', 'price' => 30.00, 'type' => 'extra'],
                    ['name_ar' => 'أرز إضافي', 'name_en' => 'Extra Rice', 'price' => 25.00, 'type' => 'extra'],
                ]
            ],
            [
                'category_id' => $grillsId,
                'name_ar' => 'كفتة مشوية',
                'name_en' => 'Grilled Kofta',
                'description_ar' => 'نصف كيلو كفتة لحم بلدي مع السلطات',
                'description_en' => 'Half kilo of local meat kofta with salads',
                'price' => 180.00,
                'main_image' => 'kofta.jpg',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $yemeniId,
                'name_ar' => 'مندي دجاج',
                'name_en' => 'Chicken Mandi',
                'description_ar' => 'دجاج مطهو على الطريقة اليمنية الأصلية في التنور',
                'description_en' => 'Chicken cooked in the authentic Yemeni way in a Tandoor',
                'price' => 120.00,
                'main_image' => 'mandi.jpg',
                'is_active' => true,
                'is_featured' => true,
                'extras' => [
                    ['name_ar' => 'حجم كامل', 'name_en' => 'Full Size', 'price' => 100.00, 'type' => 'size'],
                    ['name_ar' => 'دبوس إضافي', 'name_en' => 'Extra Drumstick', 'price' => 45.00, 'type' => 'extra'],
                ]
            ],
            [
                'category_id' => $yemeniId,
                'name_ar' => 'مظبي لحم',
                'name_en' => 'Meat Madhbi',
                'description_ar' => 'لحم بلدي مطهو فوق الحجر الساخن',
                'description_en' => 'Local meat cooked over hot stones',
                'price' => 220.00,
                'main_image' => 'madhbi.jpg',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $appetizersId,
                'name_ar' => 'حمص',
                'name_en' => 'Hummus',
                'description_ar' => 'حمص بالطحينة وزيت الزيتون',
                'description_en' => 'Hummus with tahini and olive oil',
                'price' => 45.00,
                'main_image' => 'hummus.jpg',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $appetizersId,
                'name_ar' => 'تبولة',
                'name_en' => 'Tabbouleh',
                'description_ar' => 'بقدونس مفروم مع برغل وبندورة وزيت زيتون',
                'description_en' => 'Chopped parsley with bulgur, tomatoes, and olive oil',
                'price' => 50.00,
                'main_image' => 'tabbouleh.jpg',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $popularId,
                'name_ar' => 'طبق كشري عائلي',
                'name_en' => 'Family Koshary Tray',
                'description_ar' => 'طبق كشري لـ 4 أشخاص مع الصلصة والدقة',
                'description_en' => 'Koshary tray for 4 people with sauce and daqqa',
                'price' => 100.00,
                'main_image' => 'koshary.jpg',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $dessertsId,
                'name_ar' => 'كنافة نابلسية',
                'name_en' => 'Nabulsi Kunafa',
                'description_ar' => 'كنافة بالجبنة النابلسية الساخنة',
                'description_en' => 'Kunafa with hot Nabulsi cheese',
                'price' => 80.00,
                'main_image' => 'kunafa.jpg',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $beveragesId,
                'name_ar' => 'عصير برتقال فريش',
                'name_en' => 'Fresh Orange Juice',
                'description_ar' => 'عصير برتقال طبيعي 100%',
                'description_en' => '100% Natural orange juice',
                'price' => 40.00,
                'main_image' => 'orange_juice.jpg',
                'is_active' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($products as $prodData) {
            $extras = $prodData['extras'] ?? [];
            unset($prodData['extras']);

            $product = Product::create($prodData);

            foreach ($extras as $extra) {
                $product->extras()->create($extra);
            }
        }
    }
}
