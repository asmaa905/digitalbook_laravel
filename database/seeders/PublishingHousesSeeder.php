<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PublishingHouse;

class PublishingHousesSeeder extends Seeder
{
   // In your PublishingHousesSeeder
public function run()
{
    \App\Models\PublishingHouse::create([
        'name' => 'Dar alsalam',
        'location' => '123 Main St',
        'website' => 'http://darsalam.com',
        'image' => 'publishing_houses/darsalam.jpg',
    ]);
}
}

