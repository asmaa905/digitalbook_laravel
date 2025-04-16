<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run()
    {
        Plan::create([
            'name' => 'Free',
            'price' => 0,
            'features' => json_encode([
                'Publish any book',
                'Up to 5 books only',
                'Users wait 10s to download',
                '1 account'
            ]),
            'book_limit' => 5,
            'instant_download' => false,
            'free_trial_days' => 0,
            'is_featured' => false
        ]);

        Plan::create([
            'name' => 'Premium',
            'price' => 9.99,
            'features' => json_encode([
                'Publish any book',
                'Unlimited books',
                'Instant downloads',
                '1 account',
            ]),
            'book_limit' => null,
            'instant_download' => true,
            'free_trial_days' => 0,
            'is_featured' => true,
            'plan_duration'=>6
        ]);
        Plan::create([
            'name' => 'Premium',
            'price' => 99.99,
            'features' => json_encode([
                'Publish any book',
                'Unlimited books',
                'Instant downloads',
                '1 account',
            ]),
            'book_limit' => null,
            'instant_download' => true,
            'free_trial_days' => 0,
            'is_featured' => false,
            'plan_duration'=>12

        ]);
    }
}