<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InteractionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['call', 'email', 'meeting', 'note']),
            'summary' => $this->faker->sentence(10),
            'happened_at' => $this->faker->dateTimeBetween('-45 days', 'now'),
        ];
    }
}
