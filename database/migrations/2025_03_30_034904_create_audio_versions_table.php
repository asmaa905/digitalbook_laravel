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
            $table->string('audio_link')->default(null); // Store audio link
            $table->string('review_record_link')->nullable(); // Optional review

            // Ensure nullable before constraint
            $table->unsignedBigInteger('created_by')->nullable(); 
            $table->decimal('audio_duration', 8, 2)->default(1);

            $table->string('language', 10)->default('en');
            $table->enum('audio_format_review', ['MP3', 'AAC', 'WAV'])->default('MP3');
            $table->enum('audio_format_full_audio', ['MP3', 'AAC', 'WAV'])->default('MP3');

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('audio_versions');
    }
};
