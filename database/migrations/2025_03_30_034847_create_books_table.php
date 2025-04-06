<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up() {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->date('publish_date');
            $table->string('pdf_link')->nullable(); // Directly store PDF link
            $table->foreignId('publish_house_id')->nullable()->constrained('publishing_houses')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('published_by')->constrained('users')->onDelete('cascade'); // Publisher or Admin
            $table->foreignId('author_id')->nullable()->constrained('authors')->onDelete('set null');
            $table->float('rating')->nullable();
            $table->timestamps();
            $table->softDeletes();

            
        });
    }

    public function down() {
        Schema::dropIfExists('books');
    }
};

     

