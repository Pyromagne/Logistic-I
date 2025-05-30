<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        static $userIndex = 0;  // This will help keep track of which user to generate next.

        $users = [
            [
                'name' => 'SUPERADMIN',
                'email' => 'superadminlgstc1@nexfleetdynamics.com',
                'email_verified_at' => now(),
                'password' => Hash::make('lgstc1superadmin1234'),
                'remember_token' => Str::random(10),
                'type' => 2050,
                'position_id' => 2000,
            ],
            [
                'name' => 'Ashleigh Koepp',
                'email' => 'ashleigh.koepp@example.net',
                'email_verified_at' => now(),
                'password' => Hash::make('lgstc1superadmin1234'),
                'remember_token' => Str::random(10),
                'type' => 2050,
            ],
            [
                'name' => 'Ricardo Aron III',
                'email' => 'aroniii.ricardo@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('lgstc1admin1234'),
                'remember_token' => Str::random(10),
                'type' => 2051,
            ],
            [
                'name' => 'Kent Mark Tejada',
                'email' => 'strawberrymilkchicken@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('lgstc1inventory1234'),
                'remember_token' => Str::random(10),
                'type' => 2052,
            ],
            [
                'name' => 'Kristel Casinillo',
                'email' => 'casinillokristeldc17@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('lgstc1infrastructure1234'),
                'remember_token' => Str::random(10),
                'type' => 2053,
            ],
            [
                'name' => 'John Vincent Dizon',
                'email' => 'shotoooh123@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('lgstc1auditor1234'),
                'remember_token' => Str::random(10),
                'type' => 2055,
            ],
            [
                'name' => 'Andy Barrantes',
                'email' => 'marshallgustavo96@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('lgstc1auditor1234'),
                'remember_token' => Str::random(10),
                'type' => 2055,
            ],
        ];

        $user = $users[$userIndex];
        $userIndex = ($userIndex + 1) % count($users);

        return $user;
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
