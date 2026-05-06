<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DealFactory extends Factory
{
    public function definition(): array
    {
        $stage = $this->faker->randomElement(['new', 'in_progress', 'negotiation', 'closed']);

        return [
            'title' => $this->faker->randomElement([
                'Annual Platform Expansion',
                'Growth Automation Suite',
                'Customer Success Rollout',
                'Regional Upsell Opportunity',
                'Q4 Retention Renewal',
            ]),
            'amount' => $this->faker->randomFloat(2, 6000, 85000),
            'stage' => $stage,
            'probability' => match ($stage) {
                'new' => $this->faker->numberBetween(10, 35),
                'in_progress' => $this->faker->numberBetween(35, 60),
                'negotiation' => $this->faker->numberBetween(60, 90),
                default => 100,
            },
            'expected_close_date' => $this->faker->dateTimeBetween('now', '+90 days'),
            'description' => $this->faker->sentence(16),
        ];
    }
}
