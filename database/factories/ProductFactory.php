<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_ar' => fake()->word(),
            'name_en' => fake()->word(),
            'description_ar' => fake()->paragraph(),
            'description_en' => fake()->paragraph(),
            'price' => $price = fake()->randomFloat(2, 10, 500),
            'discount_price' => fake()->boolean(30) ? $price * 0.8 : null,
            'time' => fake()->time('H:i'),
            'main_image' => 'default_product.png',  // Placeholder since we don't have actual images
            'category_id' => Category::inRandomOrder()->first()->id ?? 1,
            'is_active' => true,
            'is_featured' => fake()->boolean(20),
        ];
    }
}
