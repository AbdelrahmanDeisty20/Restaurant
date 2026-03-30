<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Governorate;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $governorates = [
            ['name_ar' => 'القاهرة', 'name_en' => 'Cairo', 'delivery_fee' => 30],
            ['name_ar' => 'الجيزة', 'name_en' => 'Giza', 'delivery_fee' => 30],
            ['name_ar' => 'الإسكندرية', 'name_en' => 'Alexandria', 'delivery_fee' => 50],
            ['name_ar' => 'الدقهلية', 'name_en' => 'Dakahlia', 'delivery_fee' => 45],
            ['name_ar' => 'البحر الأحمر', 'name_en' => 'Red Sea', 'delivery_fee' => 100],
            ['name_ar' => 'البحيرة', 'name_en' => 'Beheira', 'delivery_fee' => 50],
            ['name_ar' => 'الفيوم', 'name_en' => 'Faiyum', 'delivery_fee' => 40],
            ['name_ar' => 'الغربية', 'name_en' => 'Gharbia', 'delivery_fee' => 45],
            ['name_ar' => 'الإسماعيلية', 'name_en' => 'Ismailia', 'delivery_fee' => 50],
            ['name_ar' => 'المنوفية', 'name_en' => 'Menofia', 'delivery_fee' => 45],
            ['name_ar' => 'المنيا', 'name_en' => 'Minya', 'delivery_fee' => 60],
            ['name_ar' => 'القليوبية', 'name_en' => 'Qalyubia', 'delivery_fee' => 35],
            ['name_ar' => 'الوادي الجديد', 'name_en' => 'New Valley', 'delivery_fee' => 100],
            ['name_ar' => 'السويس', 'name_en' => 'Suez', 'delivery_fee' => 50],
            ['name_ar' => 'أسوان', 'name_en' => 'Aswan', 'delivery_fee' => 80],
            ['name_ar' => 'أسيوط', 'name_en' => 'Asyut', 'delivery_fee' => 70],
            ['name_ar' => 'بني سويف', 'name_en' => 'Beni Suef', 'delivery_fee' => 45],
            ['name_ar' => 'بورسعيد', 'name_en' => 'Port Said', 'delivery_fee' => 50],
            ['name_ar' => 'دمياط', 'name_en' => 'Damietta', 'delivery_fee' => 50],
            ['name_ar' => 'الشرقية', 'name_en' => 'Sharkia', 'delivery_fee' => 45],
            ['name_ar' => 'جنوب سيناء', 'name_en' => 'South Sinai', 'delivery_fee' => 100],
            ['name_ar' => 'كفر الشيخ', 'name_en' => 'Kafr el-Sheikh', 'delivery_fee' => 50],
            ['name_ar' => 'مطروح', 'name_en' => 'Matrouh', 'delivery_fee' => 80],
            ['name_ar' => 'الأقصر', 'name_en' => 'Luxor', 'delivery_fee' => 80],
            ['name_ar' => 'قنا', 'name_en' => 'Qena', 'delivery_fee' => 75],
            ['name_ar' => 'شمال سيناء', 'name_en' => 'North Sinai', 'delivery_fee' => 100],
            ['name_ar' => 'سوهاج', 'name_en' => 'Sohag', 'delivery_fee' => 70],
        ];

        foreach ($governorates as $gov) {
            Governorate::updateOrCreate(
                ['name_en' => $gov['name_en']],
                $gov
            );
        }
    }
}
