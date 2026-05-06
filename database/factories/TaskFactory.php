<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'in_progress', 'completed']);

        return [
            'title' => fake()->randomElement([
                'Prepare proposal deck',
                'Send follow-up email',
                'Schedule renewal call',
                'Review customer onboarding checklist',
                'Confirm legal approval',
                'Update pipeline forecast',
            ]),
            'description' => fake()->sentence(12),
            'due_date' => fake()->dateTimeBetween('-3 days', '+18 days'),
            'status' => $status,
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'completed_at' => $status === 'completed' ? fake()->dateTimeBetween('-7 days', 'now') : null,
        ];
    }
}
