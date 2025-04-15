<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'fatma',
            'email' => 'admin@ebook.com',
            'password' => Hash::make('fatmafkk'), // Properly hashed
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}
