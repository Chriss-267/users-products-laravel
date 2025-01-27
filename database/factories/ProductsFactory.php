<?php

namespace Database\Factories;

use App\Models\distributors;
use App\Models\product_categories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'name' => fake()->word(),
                'description' => fake()->paragraph(),
                'price' => fake()->randomFloat(2, 10, 1000),
                'stock' => fake()->numberBetween(0, 500),
                'category_id' => product_categories::factory(),
                'distributor_id' => distributors::factory(),
                'status' => fake()->randomElement(['available', 'out_of_stock', 'discontinued'])
        ];
    }
}
