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
    public function run(): void
    {
        $categories = Category::pluck('id');
        $houses = PublishingHouse::pluck('id');
        $publishers = User::whereIn('role', ['Publisher', 'Admin'])->pluck('id');
        $authors = Author::pluck('id');
        //Lajo Jose
        //crime
        $books = [
            ['title' => "Ruthinte Lokam", 'image' => "books/Ruthinte_Lokam.jpeg"],
            ['title' => "Mrutyunjay Bhag 1 - Karn", 'image' => "books/Mrutyunjay_Bhag_Karn.jpeg"],
            ['title' => "المطارد", 'image' => "books/hakmgan.jpeg"],
            ['title' => "parwaaz- wings of fire", 'image' => "books/parwaaz- wings of fire.jpeg"],
            ['title' => "Ruthinte Lokam", 'image' => "books/Ruthinte_Lokam.jpeg"],
            ['title' => "فقط اصمت وافعلها كيف تبدأ وتستمر", 'image' => "books/فقط-اصمت-وافعلها-كيف-تبدأ-وتستمر.jpeg"],
         
            ['title' => "The Effective Executive: The Definitive Guide to Getting the Right Things Done", 'image' => "books/The_Effective.jpeg"],
            ['title' => "Homo Deus: A Brief History of Tomorrow", 'image' => "books/Homo_Deus.jpeg"],
            ['title' => "Sapiens: A Brief History of Humankind", 'image' => "books/Sapiens_A_Brief.jpeg"],
            ['title' => "The Alchemist", 'image' => "books/The_Alchemist.jpeg"],
            ['title' => "صحتك بالدنيا", 'image' => "books/صحتك بالدنيا.jpeg"],
        ];

        foreach ($books as $book) {
                Book::create([
            'category_id' => $categories->random(),
            'publish_house_id' => $houses->random(),
            'published_by' => $publishers->random(),
            'author_id' => $authors->random(),
            'title' => $book['title'],
            'image' => $book['image'], 
            'publish_date' => 2020 , 
      
            // 'price' => 500, 
            'description' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis neque esse repellat maxime, excepturi, voluptatem praesentium porro itaque, ",
            'rating' => 3, 
            'pdf_link' => "books_pdf/book_defualt.pdf", 
            'is_published'=>'accepted',

           'is_featured'=>true,
            'language'=>'en',
            ]);
        }
    }
}