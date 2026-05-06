<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'company' => fake()->company(),
            'tag' => fake()->randomElement(['vip', 'regular', 'partner']),
            'status' => fake()->randomElement(['active', 'onboarding', 'churn-risk']),
            'industry' => fake()->randomElement(['SaaS', 'Healthcare', 'Finance', 'Retail', 'Education']),
            'address' => fake()->city().', '.fake()->stateAbbr(),
            'notes' => fake()->sentence(14),
            'joined_at' => fake()->dateTimeBetween('-18 months', '-10 days'),
        ];
    }
}
