<?php

namespace Database\Seeders;

use App\Models\ProductExtra;
use Illuminate\Database\Seeder;

class ProductExtraSeeder extends Seeder
{
    public function run(): void
    {
        ProductExtra::truncate();

        $extras = [
            // صلصات
            ['name_ar' => 'صوص رانش', 'name_en' => 'Ranch Sauce', 'price' => 15.0],
            ['name_ar' => 'صوص ثومية', 'name_en' => 'Garlic Sauce', 'price' => 10.0],
            ['name_ar' => 'صوص حار', 'name_en' => 'Hot Sauce', 'price' => 10.0],
            ['name_ar' => 'صوص بيبر', 'name_en' => 'Pepper Sauce', 'price' => 12.0],
            ['name_ar' => 'صوص تتر', 'name_en' => 'Tartar Sauce', 'price' => 12.0],
            ['name_ar' => 'صوص كيتشاب', 'name_en' => 'Ketchup', 'price' => 5.0],
            ['name_ar' => 'مايونيز', 'name_en' => 'Mayonnaise', 'price' => 5.0],
            // إضافات بروتين
            ['name_ar' => 'إضافة جبنة شيدر', 'name_en' => 'Cheddar Cheese', 'price' => 25.0],
            ['name_ar' => 'إضافة بيض', 'name_en' => 'Extra Egg', 'price' => 15.0],
            ['name_ar' => 'إضافة دجاج مشوي', 'name_en' => 'Grilled Chicken', 'price' => 45.0],
            ['name_ar' => 'إضافة كفتة', 'name_en' => 'Extra Kofta', 'price' => 40.0],
            // جانبيات
            ['name_ar' => 'بطاطس مقلية', 'name_en' => 'French Fries', 'price' => 30.0],
            ['name_ar' => 'أرز زيادة', 'name_en' => 'Extra Rice', 'price' => 30.0],
            ['name_ar' => 'خبز إضافي', 'name_en' => 'Extra Bread', 'price' => 10.0],
            ['name_ar' => 'سلطة خضراء', 'name_en' => 'Green Salad', 'price' => 20.0],
            ['name_ar' => 'تبولة', 'name_en' => 'Tabbouleh', 'price' => 20.0],
            ['name_ar' => 'حمص', 'name_en' => 'Hummus', 'price' => 20.0],
            ['name_ar' => 'بابا غنوج', 'name_en' => 'Baba Ghanoush', 'price' => 20.0],
            // مشروبات إضافية
            ['name_ar' => 'مياه معدنية', 'name_en' => 'Mineral Water', 'price' => 10.0],
            ['name_ar' => 'مشروب غازي', 'name_en' => 'Soft Drink', 'price' => 20.0],
            // توبينج وإضافات خفيفة
            ['name_ar' => 'فلفل حار إضافي', 'name_en' => 'Extra Chili', 'price' => 5.0],
            ['name_ar' => 'زيادة مخلل', 'name_en' => 'Extra Pickles', 'price' => 5.0],
            ['name_ar' => 'زيتون', 'name_en' => 'Olives', 'price' => 10.0],
            ['name_ar' => 'مكسرات', 'name_en' => 'Nuts', 'price' => 20.0],
            ['name_ar' => 'زبيب', 'name_en' => 'Raisins', 'price' => 10.0],
        ];

        foreach ($extras as $extra) {
            ProductExtra::create($extra);
        }
    }
}
