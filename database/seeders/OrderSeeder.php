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
                    'total_price' => 0,  // Will calculate after adding items
                    'status' => collect(['pending', 'preparing', 'on_the_way', 'delivered', 'cancelled'])->random(),
                    'notes' => 'Some test order notes',
                    'customer_name' => $user->name,
                    'customer_phone' => $user->phone ?? '01000000000',
                    'delivery_address' => 'Test Address',
                    'payment_method' => 'cash',
                ]);

                // Log initial status
                $order->statusHistories()->create([
                    'status' => $order->status,
                    'notes' => 'Order created via seeder',
                ]);

                $total = 0;
                $orderProducts = $products->random(rand(1, 3));

                foreach ($orderProducts as $product) {
                    $qty = rand(1, 2);
                    $size = $product->sizes->first();  // Use first size as fallback
                    $unitPrice = $size ? $size->price : ($product->price > 0 ? $product->price : 0);
                    $price = $unitPrice * $qty;
                    $total += $price;

                    $order->items()->attach($product->id, [
                        'quantity' => $qty,
                        'price' => $unitPrice,
                        'product_size_id' => $size ? $size->id : null,
                        'extras' => json_encode([]),
                    ]);
                }

                $order->update(['total_price' => $total]);
            }
        }
    }
}
