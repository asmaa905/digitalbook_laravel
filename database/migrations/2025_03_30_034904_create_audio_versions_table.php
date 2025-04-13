<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('audio_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->string('audio_link');
            $table->string('review_record_link')->nullable();
            $table->string('language', 10)->default('en');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->decimal('audio_duration', 10, 2)->default(0);
            $table->enum('is_published', ['waiting','accepted', 'rejected'])->default('waiting');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('audio_versions');
    }
};