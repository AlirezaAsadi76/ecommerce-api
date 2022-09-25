<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'billing_email' => fake()->email,
            'billing_name' => fake()->name,
            'billing_address' => fake()->address,
            'billing_city' => fake()->city,
            'billing_province' => fake()->city,
            'billing_postalcode' => fake()->postcode,
            'billing_phone' => fake()->phoneNumber,
            'billing_name_on_card' => fake()->name,
            'billing_subtotal' => rand(100,10000),
            'billing_tax' => rand(100,10000),
            'billing_total' => rand(100,10000)
        ];
    }
}
