<?php

namespace Database\Factories;

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
          'name' => $this->faker->word() . ' ' . $this->faker->randomElement(['Laptop', 'Phone', 'Headphones', 'Speaker', 'Monitor']),
            'display_image' => $this->faker->imageUrl(640, 480, 'electronics', true),
            'price' => $this->faker->randomFloat(2, 50, 2000), // Prices between $50 and $2000
            'quantity' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->sentence(10),
        ];
    }
}
