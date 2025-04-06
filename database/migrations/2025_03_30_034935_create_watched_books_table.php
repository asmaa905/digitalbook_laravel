<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   
     public function up()
     {
         Schema::create('watched_books', function (Blueprint $table) {
             $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
             $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
             $table->date('watched_date');
         });
     }
 
     public function down()
     {
         Schema::dropIfExists('watched_books');
     }
};
