<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicineDetails>
 */
class MedicineDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Syrup', 'Injection', 'Tablet', 'Ointment'];
        return [
            'dose' => fake()->word(),
            'type' => $types[rand(0,3)],
            'price' => fake()->numberBetween(1000, 10000000),
            'expiry_date' => fake()->dateTimeBetween('+1 day', '+1 year'),
        ];
    }
}
