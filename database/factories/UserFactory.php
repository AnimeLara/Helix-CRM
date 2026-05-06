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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'job_title' => fake()->randomElement(['Account Executive', 'Sales Manager', 'Growth Lead']),
            'role' => fake()->randomElement(['admin', 'manager', 'sales']),
            'theme' => fake()->randomElement(['light', 'dark']),
            'notification_preferences' => [
                'email_updates' => fake()->boolean(85),
                'deal_alerts' => fake()->boolean(70),
                'weekly_summary' => true,
            ],
            'avatar_color' => fake()->randomElement(['emerald', 'sky', 'amber', 'rose']),
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
