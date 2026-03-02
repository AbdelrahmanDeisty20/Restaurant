<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name_ar', 'value' => 'مطعم النيل', 'type' => 'text'],
            ['key' => 'site_name_en', 'value' => 'Nile Restaurant', 'type' => 'text'],
            ['key' => 'contact_phone', 'value' => '01000000000', 'type' => 'text'],
            ['key' => 'contact_email', 'value' => 'info@nilerestaurant.com', 'type' => 'text'],
            ['key' => 'address_ar', 'value' => 'القاهرة، مدينة نصر، شارع عباس العقاد', 'type' => 'text'],
            ['key' => 'address_en', 'value' => 'Abbas El Akkad St, Nasr City, Cairo', 'type' => 'text'],
            ['key' => 'currency_ar', 'value' => 'ج.م', 'type' => 'text'],
            ['key' => 'currency_en', 'value' => 'EGP', 'type' => 'text'],
            ['key' => 'facebook_link', 'value' => 'https://facebook.com/nilerestaurant', 'type' => 'text'],
            ['key' => 'instagram_link', 'value' => 'https://instagram.com/nilerestaurant', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
