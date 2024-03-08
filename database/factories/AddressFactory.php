<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cities = ['Damascus', 'Homs', 'Aleppo', 'Tartus', 'Hama', 'Rif-Dimashq', 'Latakia', 'Quneitra', 'Daraa', 'Al-Suwayda', 'Deir Ez-Zor', 'Al-Raqqa', 'Al-Hasaka', 'Idlib'];
        return [
            'name' => fake()->company(),
            'city' => $cities[rand(0,13)],
            'street' => fake()->address(),
            'region' => fake()->streetAddress(),
        ];
    }
}
