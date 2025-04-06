<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WatchedBooksSeeder extends Seeder
{
    public function run()
    {
        $userIds = DB::table('users')->pluck('id')->toArray();
        $bookIds = DB::table('books')->pluck('id')->toArray();

        for ($i = 0; $i < 3; $i++) {
            DB::table('watched_books')->insert([
                'user_id' => $userIds[array_rand($userIds)],
                'book_id' => $bookIds[array_rand($bookIds)],
                'watched_date' => Carbon::now()->subDays(rand(1, 30))->toDateString(),
            ]);
        }
    }
}

