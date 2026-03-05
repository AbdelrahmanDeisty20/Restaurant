<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    public function run(): void
    {
        // حذف العروض القديمة وإعادة الإنشاء
        Offer::truncate();

        $products = Product::inRandomOrder()->take(10)->get();

        $offers = [
            ['percentage' => 50.0, 'label' => 'Ramadan Special'],
            ['percentage' => 30.0, 'label' => 'Summer Deal'],
            ['percentage' => 20.0, 'label' => 'Flash Sale'],
            ['percentage' => 15.0, 'label' => 'Weekend Offer'],
            ['percentage' => 10.0, 'label' => 'Welcome Pack'],
        ];

        foreach ($products as $index => $product) {
            $offerData = $offers[$index % count($offers)];
            Offer::create([
                'product_id' => $product->id,
                'discount_percentage' => $offerData['percentage'],
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(rand(1, 6)),
                'is_active' => true,
            ]);
        }
    }
}
