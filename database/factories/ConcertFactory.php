<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Concert>
 */
class ConcertFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => \App\Models\Event::factory(), // This will automatically create an Event if not specified.
            'date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'location' => $this->faker->city,
            'capacity_total' => $this->faker->numberBetween(100, 1000),
            'tickets_sold' => 0,
            'price' => $this->faker->randomFloat(2, 10, 100) // Prices between 10 and 100
        ];
    }
}
