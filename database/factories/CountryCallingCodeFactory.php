<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CountryCallingCode>
 */
class CountryCallingCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country' => $this->faker->country(),
            'calling_code' => '+' . $this->faker->numberBetween(1, 999),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
