<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'fatma',
            'email' => 'admin@ebook.com',
            'password' => bcrypt('fatmafkk'), // Properly hashed password
            'role' => 'admin', // Correct role assignment
            'email_verified_at' => now(),
        ]);
    }
}
