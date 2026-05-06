<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DealFactory extends Factory
{
    public function definition(): array
    {
        $stage = fake()->randomElement(['new', 'in_progress', 'negotiation', 'closed']);

        return [
            'title' => fake()->randomElement([
                'Annual Platform Expansion',
                'Growth Automation Suite',
                'Customer Success Rollout',
                'Regional Upsell Opportunity',
                'Q4 Retention Renewal',
            ]),
            'amount' => fake()->randomFloat(2, 6000, 85000),
            'stage' => $stage,
            'probability' => match ($stage) {
                'new' => fake()->numberBetween(10, 35),
                'in_progress' => fake()->numberBetween(35, 60),
                'negotiation' => fake()->numberBetween(60, 90),
                default => 100,
            },
            'expected_close_date' => fake()->dateTimeBetween('now', '+90 days'),
            'description' => fake()->sentence(16),
        ];
    }
}
