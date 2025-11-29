<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = [
            'name' => fake()->unique()->userName(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'user',
            'remember_token' => Str::random(10),
        ];

        if (Schema::hasColumn('users', 'email')) {
            $data['email'] = fake()->unique()->safeEmail();
            $data['email_verified_at'] = now();
        }

        if (Schema::hasColumn('users', 'username')) {
            $data['username'] = fake()->unique()->userName();
        }

        return $data;
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
