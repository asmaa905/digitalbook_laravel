<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use Faker\Factory as Faker;

class AuthorSeeder extends Seeder
{
    public function run()
    {
        // Author::factory(5)->create();

        
        $faker = Faker::create();

        // Create 5 demo users
        for ($i = 0; $i < 5; $i++) {
            Author::create([
                'name' => $faker->name(),
                'bio' => $faker->name(),
                'image' => null,

            ]);
        }
    }
}
