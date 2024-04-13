<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'concert_id' => \App\Models\Concert::factory(), // This will automatically create a Concert if not specified.
            'user_id' => \App\Models\User::factory(), // This will automatically create a User if not specified.
            'status' => $this->faker->randomElement(['available', 'sold'])
        ];
    }
}
