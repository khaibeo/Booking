<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StoreSchedule>
 */
class StoreScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'store_id' => fake()->numberBetween(1, 10),
            'date' => fake()->date(),
            'opening_time' => fake()->time(),
            'closing_time' => fake()->time(),
        ];
    }
}
