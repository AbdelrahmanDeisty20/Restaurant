<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\DriverReview;
use App\Models\Order;
use App\Models\OrderReview;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('email', '!=', 'admin@admin.com')->get();
        $orders = Order::where('status', 'delivered')->get();
        $drivers = Driver::all();

        if ($orders->isEmpty()) {
            return;
        }

        foreach ($orders as $order) {
            // 1. Order Review (interconnected review)
            $orderReview = OrderReview::create([
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'rating' => rand(4, 5),
                'comment' => 'Great service and fast delivery!',
            ]);

            // 2. Product Reviews for items in this order
            foreach ($order->items as $product) {
                ProductReview::create([
                    'order_review_id' => $orderReview->id,
                    'user_id' => $order->user_id,
                    'product_id' => $product->id,
                    'rating' => rand(4, 5),
                    'comment' => "The {$product->name_en} was delicious!",
                ]);
            }

            // 3. Driver Review
            if ($drivers->isNotEmpty()) {
                DriverReview::create([
                    'driver_id' => $drivers->random()->id,
                    'order_review_id' => $orderReview->id,
                    'rating' => rand(4, 5),
                    'comment' => 'The driver was very polite.',
                ]);
            }
        }
    }
}
