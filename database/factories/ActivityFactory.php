<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'icon' => fake()->randomElement(['sparkles', 'chart-bar', 'check-circle', 'chat-bubble-left-right']),
            'action' => fake()->randomElement(['deal_update', 'task_complete', 'lead_touchpoint']),
            'description' => fake()->sentence(10),
            'occurred_at' => fake()->dateTimeBetween('-14 days', 'now'),
        ];
    }
}
