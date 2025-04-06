<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('publishing_houses', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->string('image')->nullable()->after('website'); // or wherever you want to place it
        });
    }

    public function down()
    {
        Schema::table('publishing_houses', function (Blueprint $table) {
            $table->string('email')->unique();
            $table->dropColumn('image');
        });
    }
};
