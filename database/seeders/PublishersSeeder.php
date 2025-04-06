<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Publisher;
use App\Models\User;
use App\Models\PublishingHouse;

class PublishersSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('role', 'Publisher')->pluck('id');
        $houses = PublishingHouse::pluck('id');

        foreach ($users as $userId) {
            Publisher::create([
                'user_id' => $userId,
                'identity' => fake()->uuid,
                'job_title' => fake()->jobTitle,
                'publishing_house_id' => $houses->random(),
            ]);
        }
    }
}
