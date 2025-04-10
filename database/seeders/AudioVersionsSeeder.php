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
        $audio_versions = [
            ['book_id'=>1,'review_record_link' => "books_audio_reviews/Ruthinte_Lokam.mp3", 'audio_link' => "books_audio_links/Ruthinte_Lokam.mp3"],
            ['book_id'=>2,'review_record_link' => "books_audio_reviews/Mrutyunjay_Bhag_Karn.mp3", 'audio_link' => "books_audio_links/Mrutyunjay_Bhag_Karn.mp3"],
            ['book_id'=>3,'review_record_link' => "books_audio_reviews/hakmgan.mp3", 'audio_link' => "books_audio_links/hakmgan.mp3"],
            ['book_id'=>4,'review_record_link' => "books_audio_reviews/parwaaz- wings of fire.mp3", 'audio_link' => "books_audio_links/parwaaz- wings of fire.mp3"],
            ['book_id'=>5,'review_record_link' => "books_audio_reviews/Ruthinte_Lokam.mp3", 'audio_link' => "books_audio_links/Ruthinte_Lokam.mp3"],
            ['book_id'=>6,'review_record_link' => "books_audio_reviews/فقط-اصمت-وافعلها-كيف-تبدأ-وتستمر.mp3", 'audio_link' => "books_audio_links/فقط-اصمت-وافعلها-كيف-تبدأ-وتستمر.mp3"],
         
            ['book_id'=>7,'review_record_link' => "books_audio_reviews/The_Effective.mp3", 'audio_link' => "books_audio_links/The_Effective.mp3"],
            ['book_id'=>8,'review_record_link' => "books_audio_reviews/Homo_Deus.mp3", 'audio_link' => "books_audio_links/Homo_Deus.mp3"],
            ['book_id'=>9,'review_record_link' => "books_audio_reviews/Sapiens_A_Brief.mp3", 'audio_link' => "books_audio_links/Sapiens_A_Brief.mp3"],
            ['book_id'=>10,'review_record_link' => "books_audio_reviews/sahtkbedonia.mp3", 'audio_link' => "books_audio_links/sahtkbedonia.mp3"],
        ];
        foreach ($audio_versions as $audio) {
            AudioVersion::create([
                'book_id' => $audio['book_id'],
                'audio_link' => $audio['audio_link'],
                'review_record_link' => $audio['review_record_link'],
                'audio_format_review' => 'MP3',
                'audio_format_full_audio' => 'MP3',
                'created_by' => $creators->random(),
        ]);
    }
    }
}
