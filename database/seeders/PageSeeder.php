<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title_ar' => 'من نحن',
                'title_en' => 'About Us',
                'content_ar' => '<p>مطعم النيل يقدم أجود أنواع المأكولات اليمنية والمشويات منذ عام 2020.</p>',
                'content_en' => '<p>Nile Restaurant serves the finest Yemeni and Grilled food since 2020.</p>',
            ],
            [
                'title_ar' => 'الشروط والأحكام',
                'title_en' => 'Terms and Conditions',
                'content_ar' => '<p>هذه هي الشروط والأحكام لاستخدام خدماتنا...</p>',
                'content_en' => '<p>These are the terms and conditions for using our services...</p>',
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
