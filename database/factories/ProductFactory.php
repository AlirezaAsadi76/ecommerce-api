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
    public function definition()
    {
        return [
            'name'=>fake()->name,
            'slug'=>fake()->slug,
            'category_id'=>Category::factory(),
            'details'=>fake()->text(50),
            'price'=>rand(10000,10000000),
            'quantity'=>rand(10,100),
            'image'=>fake()->imageUrl(),
            'description'=>fake()->text
        ];
    }
}
