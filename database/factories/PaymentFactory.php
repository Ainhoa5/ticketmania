<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'ticket_id' => \App\Models\Ticket::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 500), // between 10 and 500
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'stripe_payment_id' => $this->faker->uuid
        ];
    }
}
