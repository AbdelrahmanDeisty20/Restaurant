<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductExtra;
use App\Models\ProductSize;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyProductSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Truncate existing data to avoid duplicates and reset IDs
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductSize::truncate();
        Product::truncate();
        ProductExtra::truncate();
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Create 6 Core Categories
        $categoriesData = [
            ['name_ar' => 'المشويات', 'name_en' => 'Grills', 'image' => 'grills.jpg'],
            ['name_ar' => 'الأطباق اليمنية', 'name_en' => 'Yemeni Dishes', 'image' => 'yemeni.jpg'],
            ['name_ar' => 'المقبلات', 'name_en' => 'Appetizers', 'image' => 'appetizers.jpg'],
            ['name_ar' => 'الشعبيات', 'name_en' => 'Popular Dishes', 'image' => 'popular.jpg'],
            ['name_ar' => 'الحلويات', 'name_en' => 'Desserts', 'image' => 'desserts.jpg'],
            ['name_ar' => 'المشروبات', 'name_en' => 'Beverages', 'image' => 'beverages.jpg'],
        ];

        $categoryMap = [];
        foreach ($categoriesData as $cat) {
            $category = Category::create([
                'name_ar' => $cat['name_ar'],
                'name_en' => $cat['name_en'],
                'image' => $cat['image'],
                'is_active' => true,
            ]);
            $categoryMap[$cat['name_en']] = $category->id;
        }

        // 2. Create Global Extras
        $extras = [
            ['name_ar' => 'ثومية إضافية', 'name_en' => 'Extra Garlic Sauce', 'price' => 2],
            ['name_ar' => 'خبز إضافي', 'name_en' => 'Extra Bread', 'price' => 1],
            ['name_ar' => 'صلصة حارة', 'name_en' => 'Hot Sauce', 'price' => 1],
            ['name_ar' => 'جبنة إضافية', 'name_en' => 'Extra Cheese', 'price' => 5],
            ['name_ar' => 'تتبيلة خاصة', 'name_en' => 'Special Dressing', 'price' => 3],
            ['name_ar' => 'أرز إضافي', 'name_en' => 'Extra Rice', 'price' => 10],
            ['name_ar' => 'طحينة', 'name_en' => 'Tahini', 'price' => 2],
            ['name_ar' => 'سلطة خضراء', 'name_en' => 'Green Salad', 'price' => 5],
        ];

        $extraIds = [];
        foreach ($extras as $extra) {
            $createdExtra = ProductExtra::create($extra);
            $extraIds[] = $createdExtra->id;
        }

        // 3. Define Products Data
        $productsData = [
            'Grills' => [
                ['ar' => 'دجاج شواية كامل', 'en' => 'Full Grilled Chicken', 'price' => 50],
                ['ar' => 'نصف دجاجة شواية', 'en' => 'Half Grilled Chicken', 'price' => 25],
                ['ar' => 'كباب لحم بلدي', 'en' => 'Fresh Meat Kebab', 'price' => 70],
                ['ar' => 'كفتة مشوية', 'en' => 'Grilled Kofta', 'price' => 60],
                ['ar' => 'شيش طاووق', 'en' => 'Shish Tawook', 'price' => 55],
                ['ar' => 'ريش غنم', 'en' => 'Lamb Chops', 'price' => 90],
                ['ar' => 'أوصال لحم', 'en' => 'Meat Awshal', 'price' => 65],
                ['ar' => 'مشوي مشكل', 'en' => 'Mixed Grill', 'price' => 85],
                ['ar' => 'عرايس لحم', 'en' => 'Meat Arayes', 'price' => 45],
            ],
            'Yemeni Dishes' => [
                ['ar' => 'مندي لحم تيس', 'en' => 'Mandi Lamb', 'price' => 80],
                ['ar' => 'مظبي دجاج شاطئ', 'en' => 'Beach Chicken Madhbi', 'price' => 45],
                ['ar' => 'حنيذ لحم بالمرخ', 'en' => 'Hanidh Meat', 'price' => 85],
                ['ar' => 'برياني دجاج', 'en' => 'Chicken Biryani', 'price' => 35],
                ['ar' => 'مضغوط دجاج', 'en' => 'Chicken Madhghout', 'price' => 35],
                ['ar' => 'مضغوط لحم', 'en' => 'Meat Madhghout', 'price' => 75],
                ['ar' => 'كبسة دجاج', 'en' => 'Chicken Kabsa', 'price' => 30],
                ['ar' => 'كبسة لحم', 'en' => 'Meat Kabsa', 'price' => 70],
                ['ar' => 'مرق لحم', 'en' => 'Meat Broth', 'price' => 15],
            ],
            'Appetizers' => [
                ['ar' => 'حمص مرسى', 'en' => 'Mersa Hummus', 'price' => 15],
                ['ar' => 'متبل باذنجان', 'en' => 'Eggplant Mutabbal', 'price' => 15],
                ['ar' => 'تبولة لبنانية', 'en' => 'Lebanese Tabbouleh', 'price' => 18],
                ['ar' => 'فتوش', 'en' => 'Fattoush', 'price' => 18],
                ['ar' => 'ورق عنب', 'en' => 'Grape Leaves', 'price' => 20],
                ['ar' => 'سمبوسة مشكلة', 'en' => 'Mixed Samosa', 'price' => 12],
                ['ar' => 'بابا غنوج', 'en' => 'Baba Ghanoush', 'price' => 15],
                ['ar' => 'سلطة حارة', 'en' => 'Spicy Salad', 'price' => 5],
            ],
            'Popular Dishes' => [
                ['ar' => 'جريش أحمر', 'en' => 'Red Jareesh', 'price' => 25],
                ['ar' => 'جريش أبيض', 'en' => 'White Jareesh', 'price' => 25],
                ['ar' => 'قرصان نجد', 'en' => 'Najd Qursan', 'price' => 25],
                ['ar' => 'مرقوق لحم', 'en' => 'Meat Marqooq', 'price' => 35],
                ['ar' => 'سليق طائفي بالدجاج', 'en' => 'Chicken Saleeg', 'price' => 40],
                ['ar' => 'مراصيع بالعسل', 'en' => 'Honey Marasee', 'price' => 20],
                ['ar' => 'عصيدة يمنية', 'en' => 'Yemeni Aseeda', 'price' => 30],
                ['ar' => 'فحسة لحم', 'en' => 'Meat Fahsa', 'price' => 45],
            ],
            'Desserts' => [
                ['ar' => 'كنافة بالقشطة', 'en' => 'Konafa with Cream', 'price' => 20],
                ['ar' => 'كنافة نابلزية', 'en' => 'Nabulsi Konafa', 'price' => 25],
                ['ar' => 'معصوب ملكي بالقشطة', 'en' => 'Royal Cream Masoub', 'price' => 30],
                ['ar' => 'عريكة جنوبية', 'en' => 'Southern Areka', 'price' => 35],
                ['ar' => 'بسبوسة سادة', 'en' => 'Plain Basbousa', 'price' => 15],
                ['ar' => 'أم علي بالمكسرات', 'en' => 'Om Ali with Nuts', 'price' => 25],
                ['ar' => 'رز بلبن', 'en' => 'Rice Pudding', 'price' => 10],
                ['ar' => 'لوتس كنافة', 'en' => 'Lotus Konafa', 'price' => 30],
            ],
            'Beverages' => [
                ['ar' => 'عصير برتقال طازج', 'en' => 'Fresh Orange Juice', 'price' => 12],
                ['ar' => 'عصير رمان طازج', 'en' => 'Fresh Pomegranate Juice', 'price' => 15],
                ['ar' => 'عصير مشكل طازج', 'en' => 'Fresh Mixed Juice', 'price' => 12],
                ['ar' => 'ليمون بالنعناع', 'en' => 'Lemon Mint', 'price' => 10],
                ['ar' => 'بيبسي عائلي', 'en' => 'Family Pepsi', 'price' => 15],
                ['ar' => 'شاي أحمر فنجان', 'en' => 'Red Tea Cup', 'price' => 2],
                ['ar' => 'شاي عدني إبريق', 'en' => 'Adani Tea Pot', 'price' => 15],
                ['ar' => 'قهوة عربية دلة', 'en' => 'Arabic Coffee Dallah', 'price' => 30],
                ['ar' => 'ماء صغير', 'en' => 'Small Water', 'price' => 1],
            ],
        ];

        // 4. Seed Products with Realistic Images
        $categoryImages = [
            'Grills' => ['grill_1.png', 'grill_2.png'],
            'Yemeni Dishes' => ['yemeni_1.png', 'yemeni_2.png'],
            'Appetizers' => ['starter_1.png', 'starter_2.png'],
            'Popular Dishes' => ['popular_1.png', 'popular_2.png'],
            'Desserts' => ['dessert_1.png', 'dessert_2.png'],
            'Beverages' => ['drink_1.png', 'drink_2.png'],
        ];

        foreach ($productsData as $catName => $products) {
            $catId = $categoryMap[$catName] ?? null;
            $images = $categoryImages[$catName] ?? ['default_product.jpg'];

            if ($catId) {
                foreach ($products as $p) {
                    $product = Product::create([
                        'category_id' => $catId,
                        'name_ar' => $p['ar'],
                        'name_en' => $p['en'],
                        'description_ar' => 'وصف لذيذ لمنتج ' . $p['ar'] . ' يتم تحضيره يومياً طازجاً بأفضل المكونات.',
                        'description_en' => 'A delicious ' . $p['en'] . ' prepared fresh daily with the finest ingredients and special spices.',
                        'price' => $p['price'],
                        'main_image' => $images[array_rand($images)],
                        'is_active' => true,
                        'is_featured' => (bool)rand(0, 1),
                        'time' => '00:' . rand(15, 59) . ':00',
                        'included_extras' => json_encode(array_rand(array_flip($extraIds), min(3, count($extraIds)))),
                    ]);

                    // Add Sizes
                    ProductSize::create([
                        'product_id' => $product->id,
                        'name_ar' => 'صغير',
                        'name_en' => 'Small',
                        'price' => $p['price'],
                    ]);
                    ProductSize::create([
                        'product_id' => $product->id,
                        'name_ar' => 'وسط',
                        'name_en' => 'Medium',
                        'price' => $p['price'] + 10,
                    ]);
                    ProductSize::create([
                        'product_id' => $product->id,
                        'name_ar' => 'كبير',
                        'name_en' => 'Large',
                        'price' => $p['price'] + 20,
                    ]);
                }
            }
        }
    }
}
