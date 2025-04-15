<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE subscriptions MODIFY COLUMN status ENUM('pending', 'confirm', 'canceled') DEFAULT 'pending'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE subscriptions MODIFY COLUMN status ENUM('pending', 'confirm') DEFAULT 'pending'");
    }
};