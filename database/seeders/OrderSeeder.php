<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('email', '!=', 'admin@admin.com')->get();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            // Create 2-3 orders per user
            for ($i = 0; $i < rand(2, 3); $i++) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => 0, // Will calculate after adding items
                    'status' => collect(['pending', 'shipped', 'delivered', 'cancelled'])->random(),
                    'notes' => 'Some test order notes',
                ]);

                $total = 0;
                $orderProducts = $products->random(rand(1, 3));

                foreach ($orderProducts as $product) {
                    $qty = rand(1, 2);
                    $price = $product->price * $qty;
                    $total += $price;

                    $order->items()->attach($product->id, [
                        'quantity' => $qty,
                        'price' => $product->price,
                        'extras' => json_encode([]),
                    ]);
                }

                $order->update(['total_price' => $total]);
            }
        }
    }
}
