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

        $products = Product::take(5)->get();

        $discounts = [25.0, 15.0, 30.0, 10.0, 20.0];

        foreach ($products as $index => $product) {
            Offer::create([
                'product_id' => $product->id,
                'discount_percentage' => $discounts[$index],
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addYear(),
                'is_active' => true,
            ]);
        }
    }
}
