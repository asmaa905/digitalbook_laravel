<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create 5 demo users
        for ($i = 0; $i < 5; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->unique()->phoneNumber(),
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // or bcrypt('password')
                'image' => null,
                'role' => $faker->randomElement(['Admin', 'Publisher', 'Reader']),
                'remember_token' => \Str::random(10),
            ]);
        }
    }
}
