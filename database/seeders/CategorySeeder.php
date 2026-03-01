<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name_ar' => 'المشويات',
                'name_en' => 'Grills',
                'image' => 'grills.jpg',
                'is_active' => true,
            ],
            [
                'name_ar' => 'الأطباق اليمنية',
                'name_en' => 'Yemeni Dishes',
                'image' => 'yemeni.jpg',
                'is_active' => true,
            ],
            [
                'name_ar' => 'المقبلات',
                'name_en' => 'Appetizers',
                'image' => 'appetizers.jpg',
                'is_active' => true,
            ],
            [
                'name_ar' => 'الشعبيات',
                'name_en' => 'Popular Dishes',
                'image' => 'popular.jpg',
                'is_active' => true,
            ],
            [
                'name_ar' => 'الحلويات',
                'name_en' => 'Desserts',
                'image' => 'desserts.jpg',
                'is_active' => true,
            ],
            [
                'name_ar' => 'المشروبات',
                'name_en' => 'Beverages',
                'image' => 'beverages.jpg',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
