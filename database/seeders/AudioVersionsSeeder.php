<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AudioVersion;
use App\Models\Book;
use App\Models\User;

class AudioVersionsSeeder extends Seeder
{
    public function run()
    {
        $books = Book::pluck('id');
        $creators = User::pluck('id');

        foreach ($books->random(5) as $bookId) {
            AudioVersion::create([
                'book_id' => $bookId,
                'audio_link' => 'https://example.com/audio/' . $bookId,
                'review_record_link' => rand(0, 1) ? 'https://example.com/review/' . $bookId : null,
                'created_by' => $creators->random(),
            ]);
        }
    }
}
