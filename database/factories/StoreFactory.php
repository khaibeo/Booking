<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'link_map' => $this->faker->url(),
            'phone' => $this->faker->phoneNumber(),
            'description' => $this->faker->paragraph(),
            'code' => $this->faker->unique()->word,
        ];
    }
}
