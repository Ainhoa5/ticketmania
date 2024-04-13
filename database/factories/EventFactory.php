<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'image_cover' => 'https://res.cloudinary.com/daf5smpr3/image/upload/v1712153037/mxuqaznl4qzkkwnls46q.png',
            'image_background' => 'https://res.cloudinary.com/daf5smpr3/image/upload/v1712153037/mxuqaznl4qzkkwnls46q.png'
        ];
    }
}
