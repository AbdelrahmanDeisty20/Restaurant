<?php

namespace Database\Seeders;

use App\Models\ProductExtra;
use Illuminate\Database\Seeder;

class ProductExtraSeeder extends Seeder
{
    public function run(): void
    {
        $extras = [
            ['name_ar' => 'صوص رانش', 'name_en' => 'Ranch Sauce', 'price' => 15.0],
            ['name_ar' => 'صوص ثومية', 'name_en' => 'Garlic Sauce', 'price' => 10.0],
            ['name_ar' => 'إضافة جبنة شيدر', 'name_en' => 'Cheddar Cheese', 'price' => 25.0],
            ['name_ar' => 'إضافة لحم مقدد', 'name_en' => 'Addition of Bacon', 'price' => 40.0],
            ['name_ar' => 'فلفل حار إضافي', 'name_en' => 'Extra Chili', 'price' => 5.0],
            ['name_ar' => 'زيادة مخلل', 'name_en' => 'Extra Pickles', 'price' => 5.0],
            ['name_ar' => 'خبز إضافي', 'name_en' => 'Extra Bread', 'price' => 10.0],
            ['name_ar' => 'أرز زيادة', 'name_en' => 'Extra Rice', 'price' => 30.0],
        ];

        foreach ($extras as $extra) {
            ProductExtra::create($extra);
        }
    }
}
