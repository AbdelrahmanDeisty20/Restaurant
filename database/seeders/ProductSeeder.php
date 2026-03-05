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
                'extras' => [
                    ['name_ar' => 'بطاطس مقلية', 'name_en' => 'French Fries', 'price' => 30.0, 'type' => 'extra'],
                    ['name_ar' => 'أرز إضافي', 'name_en' => 'Extra Rice', 'price' => 25.0, 'type' => 'extra'],
                    ['name_ar' => 'سلطة خضراء', 'name_en' => 'Green Salad', 'price' => 15.0, 'type' => 'extra'],
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
                'extras' => [
                    ['name_ar' => 'طحينة زيادة', 'name_en' => 'Extra Tahini', 'price' => 10.0, 'type' => 'extra'],
                    ['name_ar' => 'عيش إضافي', 'name_en' => 'Extra Bread', 'price' => 5.0, 'type' => 'extra'],
                ]
            ],
            [
                'category_id' => $grillsId,
                'name_ar' => 'شيش طاووق',
                'name_en' => 'Shish Tawook',
                'description_ar' => 'قطع دجاج متبلة ومشويه على الفحم',
                'description_en' => 'Marinated chicken pieces grilled over charcoal',
                'price' => 160.0,
                'discount_price' => 140.0,
                'main_image' => 'shish_tawook.jpg',
                'is_active' => true,
                'is_featured' => true,
                'time' => '00:20',
                'extras' => [
                    ['name_ar' => 'ثومية إضافية', 'name_en' => 'Extra Garlic Sauce', 'price' => 12.0, 'type' => 'extra'],
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
                'extras' => [
                    ['name_ar' => 'حجم كامل', 'name_en' => 'Full Size', 'price' => 100.0, 'type' => 'size'],
                    ['name_ar' => 'دبوس إضافي', 'name_en' => 'Extra Drumstick', 'price' => 45.0, 'type' => 'extra'],
                ]
            ],
            [
                'category_id' => $yemeniId,
                'name_ar' => 'لحم حنيذ',
                'name_en' => 'Meat Haneeth',
                'description_ar' => 'لحم خروف مطهو في المرخ على الطريقة اليمنية',
                'description_en' => 'Lamb meat cooked in Markh the Yemeni way',
                'price' => 350.0,
                'discount_price' => 320.0,
                'main_image' => 'haneeth.jpg',
                'is_active' => true,
                'is_featured' => true,
                'time' => '01:30',
                'extras' => [
                    ['name_ar' => 'مكسرات', 'name_en' => 'Nuts', 'price' => 40.0, 'type' => 'extra'],
                ]
            ],
            [
                'category_id' => $yemeniId,
                'name_ar' => 'مظبي لحم',
                'name_en' => 'Meat Madhbi',
                'description_ar' => 'لحم بلدي مطهو فوق الحجر الساخن',
                'description_en' => 'Local meat cooked over hot stones',
                'price' => 220.0,
                'discount_price' => 0,
                'main_image' => 'madhbi.jpg',
                'is_active' => true,
                'is_featured' => true,
                'time' => '00:45',
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
            ],
            [
                'category_id' => $appetizersId,
                'name_ar' => 'فتوش',
                'name_en' => 'Fattoush',
                'description_ar' => 'سلطة خضروات متنوعة مع خبز محمص ودبس رمان',
                'description_en' => 'Mixed vegetable salad with toasted bread and pomegranate molasses',
                'price' => 55.0,
                'discount_price' => 50.0,
                'main_image' => 'fattoush.jpg',
                'is_active' => true,
                'is_featured' => false,
                'time' => '00:15',
            ],
            [
                'category_id' => $popularId,
                'name_ar' => 'ملوخية بالفراخ',
                'name_en' => 'Molokhia with Chicken',
                'description_ar' => 'ملوخية مصرية أصلية مع دجاج محمر وأرز',
                'description_en' => 'Authentic Egyptian Molokhia with roasted chicken and rice',
                'price' => 140.0,
                'discount_price' => 125.0,
                'main_image' => 'molokhia.jpg',
                'is_active' => true,
                'is_featured' => true,
                'time' => '00:30',
            ],
            [
                'category_id' => $popularId,
                'name_ar' => 'مكرونة بشاميل',
                'name_en' => 'Macarona Bechamel',
                'description_ar' => 'مكرونة بالفرن مع اللحم المفروم وصلصة البشاميل',
                'description_en' => 'Baked pasta with minced meat and Bechamel sauce',
                'price' => 90.0,
                'discount_price' => 0,
                'main_image' => 'bechamel.jpg',
                'is_active' => true,
                'is_featured' => false,
                'time' => '00:40',
                'extras' => [
                    ['name_ar' => 'جبنة زيادة', 'name_en' => 'Extra Cheese', 'price' => 20.0, 'type' => 'extra'],
                ]
            ],
            [
                'category_id' => $dessertsId,
                'name_ar' => 'بقلاوة مشكلة',
                'name_en' => 'Mix Baklava',
                'description_ar' => 'تشكيلة من البقلاوة الشرقية الفاخرة',
                'description_en' => 'A variety of premium Oriental Baklava',
                'price' => 150.0,
                'discount_price' => 130.0,
                'main_image' => 'baklava.jpg',
                'is_active' => true,
                'is_featured' => true,
                'time' => '00:10',
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
                'extras' => [
                    ['name_ar' => 'بولا أيس كريم', 'name_en' => 'Ice Cream Scoop', 'price' => 15.0, 'type' => 'extra'],
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
            ],
            [
                'category_id' => $beveragesId,
                'name_ar' => 'كركديه مثلوج',
                'name_en' => 'Iced Hibiscus',
                'description_ar' => 'كركديه طبيعي منعش وبارد',
                'description_en' => 'Natural refreshing and cold hibiscus',
                'price' => 30.0,
                'discount_price' => 0,
                'main_image' => 'hibiscus.jpg',
                'is_active' => true,
                'is_featured' => false,
                'time' => '00:05',
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
