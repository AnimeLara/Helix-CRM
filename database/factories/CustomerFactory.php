<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'company' => $this->faker->company(),
            'tag' => $this->faker->randomElement(['vip', 'regular', 'partner']),
            'status' => $this->faker->randomElement(['active', 'onboarding', 'churn-risk']),
            'industry' => $this->faker->randomElement(['SaaS', 'Healthcare', 'Finance', 'Retail', 'Education']),
            'address' => $this->faker->city().', '.$this->faker->stateAbbr(),
            'notes' => $this->faker->sentence(14),
            'joined_at' => $this->faker->dateTimeBetween('-18 months', '-10 days'),
        ];
    }
}
