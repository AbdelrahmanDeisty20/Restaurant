<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OfferSeeder extends Seeder
{
    public function run(): void
    {
        $product1 = Product::first();
        $product2 = Product::skip(1)->first();

        $offers = [
            [
                'product_id' => $product1?->id ?? 1,
                'discount_percentage' => 20.00,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(1),
                'is_active' => true,
            ],
            [
                'product_id' => $product2?->id ?? 2,
                'discount_percentage' => 15.00,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(7),
                'is_active' => true,
            ],
        ];

        foreach ($offers as $offer) {
            Offer::create($offer);
        }
    }
}
