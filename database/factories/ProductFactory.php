<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
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
        $name = $this->faker->sentence(3);
        $price_mx = $this->faker->randomFloat(2, 10, 1000);
        $price_us = $price_mx * 18.6;

        return [
            'name' => $name,
            'image_url' => 'https://picsum.photos/seed/' . $this->faker->uuid() . '/640/480',
            'category_id' => $this->faker->numberBetween(1, 8),
            'slug' => Str::slug($name),
            'description_short' => $this->faker->sentence(3),
            'description_long' => $this->faker->paragraph(2),
            'price_mx' => $price_mx,
            'price_usd' => $price_us,
            'stock' => $this->faker->numberBetween(0, 100),
            'is_active' => $this->faker->boolean,
        ];
    }
}
