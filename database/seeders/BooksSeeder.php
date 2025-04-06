<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;
use App\Models\PublishingHouse;
use App\Models\User;
use App\Models\Author;

class BooksSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::pluck('id');
        $houses = PublishingHouse::pluck('id');
        $publishers = User::whereIn('role', ['Publisher', 'Admin'])->pluck('id');
        $authors = Author::pluck('id');

        Book::factory(10)->create([
            'category_id' => $categories->random(),
            'publish_house_id' => $houses->random(),
            'published_by' => $publishers->random(),
            'author_id' => $authors->random(),
        ]);
    }
}
