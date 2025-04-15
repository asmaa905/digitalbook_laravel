<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            PublishingHousesSeeder::class,
            PublishersSeeder::class,
            CategoriesSeeder::class,
            AuthorSeeder::class,
            BooksSeeder::class,
            AudioVersionsSeeder::class,
            PlanSeeder::class,

        ]);
    }
    

}
