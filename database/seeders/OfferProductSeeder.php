<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OfferProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        if ($categories->isEmpty()) {
            $this->command->error('No categories found. Please run CategorySeeder or DummyProductSeeder first.');
            return;
        }

        $offerProducts = [
            [
                'name_ar' => 'وجبة عرض مشويات',
                'name_en' => 'Grill Offer Meal',
                'description_ar' => 'عرض خاص على مشوياتنا المميزة، وجبة كاملة بسعر لا يقاوم.',
                'description_en' => 'Special offer on our signature grills, a full meal at an irresistible price.',
                'price' => 100,
                'discount_price' => 75,
                'category_en' => 'Grills',
            ],
            [
                'name_ar' => 'عرض مندي دجاج',
                'name_en' => 'Mandi Chicken Offer',
                'description_ar' => 'دجاج مندي مطهو ببطء مع الأرز البسمتي، عرض خاص لفترة محدودة.',
                'description_en' => 'Slow-cooked chicken mandi with basmati rice, special limited time offer.',
                'price' => 60,
                'discount_price' => 45,
                'category_en' => 'Yemeni Dishes',
            ],
            [
                'name_ar' => 'كومبو مقبلات',
                'name_en' => 'Appetizer Combo',
                'description_ar' => 'تشكيلة من أفضل مقبلاتنا في طبق واحد بسعر خاص.',
                'description_en' => 'A variety of our best appetizers in one plate at a special price.',
                'price' => 40,
                'discount_price' => 25,
                'category_en' => 'Appetizers',
            ],
            [
                'name_ar' => 'حلويات الشيف',
                'name_en' => 'Chef\'s Dessert',
                'description_ar' => 'طبق حلويات مشكل من اختيار الشيف بعرض حصري.',
                'description_en' => 'Mixed dessert plate selected by the chef with an exclusive offer.',
                'price' => 30,
                'discount_price' => 20,
                'category_en' => 'Desserts',
            ],
            [
                'name_ar' => 'عرض العائلة بيبسي',
                'name_en' => 'Family Pepsi Offer',
                'description_ar' => 'عرض خاص على عبوات البيبسي العائلية.',
                'description_en' => 'Special offer on family-sized Pepsi bottles.',
                'price' => 20,
                'discount_price' => 15,
                'category_en' => 'Beverages',
            ],
        ];

        foreach ($offerProducts as $pData) {
            $cat = $categories->where('name_en', $pData['category_en'])->first() ?? $categories->first();
            
            $product = Product::create([
                'category_id' => $cat->id,
                'name_ar' => $pData['name_ar'],
                'name_en' => $pData['name_en'],
                'description_ar' => $pData['description_ar'],
                'description_en' => $pData['description_en'],
                'price' => $pData['price'],
                'discount_price' => $pData['discount_price'],
                'main_image' => 'default_product.jpg',
                'is_active' => true,
                'is_featured' => true,
                'time' => '00:20:00',
            ]);

            // Create corresponding Offer
            Offer::create([
                'product_id' => $product->id,
                'discount_percentage' => (($pData['price'] - $pData['discount_price']) / $pData['price']) * 100,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(3),
                'is_active' => true,
            ]);
        }
    }
}
