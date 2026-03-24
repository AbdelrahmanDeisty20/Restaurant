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
        // 0. Truncate existing data to avoid duplicates
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductSize::truncate();
        Product::truncate();
        ProductExtra::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Create Global Extras
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

        // 2. Define Products Data (Expanded for ~50 products)
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
                ['ar' => 'عصير برتقال', 'en' => 'Orange Juice', 'price' => 12],
                ['ar' => 'عصير رمان', 'en' => 'Pomegranate Juice', 'price' => 15],
                ['ar' => 'عصير مشكل', 'en' => 'Mixed Juice', 'price' => 12],
                ['ar' => 'ليمون بالنعناع', 'en' => 'Lemon Mint', 'price' => 10],
                ['ar' => 'بيبسي عائلي', 'en' => 'Family Pepsi', 'price' => 15],
                ['ar' => 'شاي أحمر فنجان', 'en' => 'Red Tea Cup', 'price' => 2],
                ['ar' => 'شاي عدني إبريق', 'en' => 'Adani Tea Pot', 'price' => 15],
                ['ar' => 'قهوة عربية دلة', 'en' => 'Arabic Coffee Dallah', 'price' => 30],
                ['ar' => 'ماء صغير', 'en' => 'Small Water', 'price' => 1],
            ],
        ];

        // 3. Seed Products for each Category
        $categories = Category::all();

        foreach ($categories as $category) {
            $categoryName = $category->name_en;
            if (isset($productsData[$categoryName])) {
                foreach ($productsData[$categoryName] as $p) {
                    $product = Product::create([
                        'category_id' => $category->id,
                        'name_ar' => $p['ar'],
                        'name_en' => $p['en'],
                        'description_ar' => 'وصف لذيذ لمنتج ' . $p['ar'] . ' يتم تحضيره يومياً طازجاً.',
                        'description_en' => 'A delicious ' . $p['en'] . ' prepared fresh daily with the finest ingredients.',
                        'price' => $p['price'],
                        'main_image' => 'default_product.jpg',
                        'is_active' => true,
                        'is_featured' => (bool)rand(0, 1),
                        'time' => rand(15, 60) . ' دقيقة',
                        'included_extras' => json_encode(array_rand(array_flip($extraIds), min(3, count($extraIds)))),
                    ]);

                    // Add Sizes with integer prices
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
