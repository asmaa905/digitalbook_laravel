<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PublishingHouse;

class PublishingHousesSeeder extends Seeder
{
    public function run()
    {
        PublishingHouse::factory(3)->create();
    }
}

