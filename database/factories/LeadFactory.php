<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    public function definition(): array
    {
        $first = $this->faker->firstName();
        $last = $this->faker->lastName();

        return [
            'name' => $first.' '.$last,
            'email' => strtolower($first.'.'.$last).'@'.$this->faker->safeEmailDomain(),
            'phone' => $this->faker->phoneNumber(),
            'company' => $this->faker->company(),
            'status' => $this->faker->randomElement(['new', 'contacted', 'qualified', 'lost']),
            'source' => $this->faker->randomElement(['website', 'referral', 'campaign', 'linkedin', 'cold-call']),
            'expected_value' => $this->faker->randomFloat(2, 2500, 75000),
            'notes' => $this->faker->sentence(12),
            'last_contacted_at' => $this->faker->optional()->dateTimeBetween('-21 days', 'now'),
        ];
    }
}
