<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = ['Fiction', 'Science', 'History', 'Biography', 'Fantasy'];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'description' => fake()->sentence,
            ]);
        }
    }
}

