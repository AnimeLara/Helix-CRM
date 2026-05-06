<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    public function definition(): array
    {
        $first = fake()->firstName();
        $last = fake()->lastName();

        return [
            'name' => $first.' '.$last,
            'email' => strtolower($first.'.'.$last).'@'.fake()->safeEmailDomain(),
            'phone' => fake()->phoneNumber(),
            'company' => fake()->company(),
            'status' => fake()->randomElement(['new', 'contacted', 'qualified', 'lost']),
            'source' => fake()->randomElement(['website', 'referral', 'campaign', 'linkedin', 'cold-call']),
            'expected_value' => fake()->randomFloat(2, 2500, 75000),
            'notes' => fake()->sentence(12),
            'last_contacted_at' => fake()->optional()->dateTimeBetween('-21 days', 'now'),
        ];
    }
}
