<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'commercial_name' => ['en' => fake()->word(), 'ar' => fake()->word()],
            'scientific_name' => ['en' => fake()->word(), 'ar' => fake()->word()],
            'description' => ['en' => fake()->text(100), 'ar' => fake()->text(100)],
        ];
    }
}
