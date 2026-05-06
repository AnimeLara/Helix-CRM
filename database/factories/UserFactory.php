<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'job_title' => $this->faker->randomElement(['Account Executive', 'Sales Manager', 'Growth Lead']),
            'role' => $this->faker->randomElement(['admin', 'manager', 'sales']),
            'theme' => $this->faker->randomElement(['light', 'dark']),
            'notification_preferences' => [
                'email_updates' => $this->faker->boolean(85),
                'deal_alerts' => $this->faker->boolean(70),
                'weekly_summary' => true,
            ],
            'avatar_color' => $this->faker->randomElement(['emerald', 'sky', 'amber', 'rose']),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
