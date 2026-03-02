<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        $drivers = [
            [
                'name' => 'أحمد علي',
                'phone' => '01012345678',
                'avatar' => 'driver1.jpg',
                'rating' => 5,
                'status' => 'available',
            ],
            [
                'name' => 'محمد سعيد',
                'phone' => '01223344556',
                'avatar' => 'driver2.jpg',
                'rating' => 4,
                'status' => 'available',
            ],
            [
                'name' => 'إبراهيم حسن',
                'phone' => '01199887766',
                'avatar' => 'driver3.jpg',
                'rating' => 5,
                'status' => 'available',
            ],
            [
                'name' => 'ياسين محمود',
                'phone' => '01555666777',
                'avatar' => 'driver4.jpg',
                'rating' => 3,
                'status' => 'unavailable',
            ],
        ];

        foreach ($drivers as $driver) {
            Driver::create($driver);
        }
    }
}
