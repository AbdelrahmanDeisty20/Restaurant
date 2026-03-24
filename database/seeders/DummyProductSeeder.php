<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductExtra;
use App\Models\ProductSize;
use Illuminate\Database\Seeder;

class DummyProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Global Extras
        $extras = [
            ['name_ar' => 'ثومية إضافية', 'name_en' => 'Extra Garlic Sauce', 'price' => 2.00],
            ['name_ar' => 'خبز إضافي', 'name_en' => 'Extra Bread', 'price' => 1.50],
            ['name_ar' => 'صلصة حارة', 'name_en' => 'Hot Sauce', 'price' => 1.00],
            ['name_ar' => 'جبنة إضافية', 'name_en' => 'Extra Cheese', 'price' => 5.00],
            ['name_ar' => 'تتبيلة خاصة', 'name_en' => 'Special Dressing', 'price' => 3.00],
        ];

        $extraIds = [];
        foreach ($extras as $extra) {
            $createdExtra = ProductExtra::create($extra);
            $extraIds[] = $createdExtra->id;
        }

        // 2. Define Products Data
        $productsData = [
            1 => [ // Grills
                ['ar' => 'دجاج شواية', 'en' => 'Grilled Chicken', 'price' => 45.00],
                ['ar' => 'كباب لحم', 'en' => 'Meat Kebab', 'price' => 60.00],
            ],
            2 => [ // Yemeni Dishes
                ['ar' => 'مندي لحم', 'en' => 'Meat Mandi', 'price' => 75.00],
                ['ar' => 'مظبي دجاج', 'en' => 'Chicken Madhbi', 'price' => 40.00],
            ],
            3 => [ // Appetizers
                ['ar' => 'حمص', 'en' => 'Hummus', 'price' => 15.00],
                ['ar' => 'متبل', 'en' => 'Mutabbal', 'price' => 15.00],
            ],
            4 => [ // Popular Dishes
                ['ar' => 'جريش', 'en' => 'Jareesh', 'price' => 25.00],
                ['ar' => 'قرصان', 'en' => 'Qursan', 'price' => 25.00],
            ],
            5 => [ // Desserts
                ['ar' => 'كنافة بالجبنة', 'en' => 'Konafa with Cheese', 'price' => 20.00],
                ['ar' => 'معصوب ملكي', 'en' => 'Royal Masoub', 'price' => 25.00],
            ],
            6 => [ // Beverages
                ['ar' => 'عصير برتقال طازج', 'en' => 'Fresh Orange Juice', 'price' => 12.00],
                ['ar' => 'شاي عدني', 'en' => 'Adani Tea', 'price' => 5.00],
            ],
        ];

        // 3. Seed Products for each Category (Handling duplicates 1-6 and 7-12)
        $categories = Category::all();

        foreach ($categories as $category) {
            // Map category names to our dummy data keys
            $key = match ($category->name_en) {
                'Grills' => 1,
                'Yemeni Dishes' => 2,
                'Appetizers' => 3,
                'Popular Dishes' => 4,
                'Desserts' => 5,
                'Beverages' => 6,
                default => null,
            };

            if ($key && isset($productsData[$key])) {
                foreach ($productsData[$key] as $p) {
                    $product = Product::create([
                        'category_id' => $category->id,
                        'name_ar' => $p['ar'],
                        'name_en' => $p['en'],
                        'description_ar' => 'وصف شهي لـ ' . $p['ar'],
                        'description_en' => 'Delicious description for ' . $p['en'],
                        'price' => $p['price'],
                        'main_image' => 'default_product.jpg',
                        'is_active' => true,
                        'is_featured' => rand(0, 1),
                        'time' => rand(15, 45) . ' min',
                        'included_extras' => json_encode(array_rand(array_flip($extraIds), rand(1, 3))),
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
