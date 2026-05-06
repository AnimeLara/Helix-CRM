<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InteractionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['call', 'email', 'meeting', 'note']),
            'summary' => fake()->sentence(10),
            'happened_at' => fake()->dateTimeBetween('-45 days', 'now'),
        ];
    }
}
