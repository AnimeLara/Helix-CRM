<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'icon' => $this->faker->randomElement(['sparkles', 'chart-bar', 'check-circle', 'chat-bubble-left-right']),
            'action' => $this->faker->randomElement(['deal_update', 'task_complete', 'lead_touchpoint']),
            'description' => $this->faker->sentence(10),
            'occurred_at' => $this->faker->dateTimeBetween('-14 days', 'now'),
        ];
    }
}
