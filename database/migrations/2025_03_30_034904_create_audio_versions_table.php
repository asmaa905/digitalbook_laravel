<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('audio_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->string('audio_link'); // Store audio link
            $table->string('review_record_link')->nullable(); // Optional review

            // Ensure nullable before constraint
            $table->unsignedBigInteger('created_by')->nullable(); 
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('audio_versions');
    }
};
