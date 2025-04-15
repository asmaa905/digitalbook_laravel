<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->json('features'); // store features saved as json array
            $table->integer('book_limit')->nullable(); // null => unlimited
            $table->boolean('instant_download')->default(false);
            $table->integer('free_trial_days')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->integer('plan_duration')->default(0)->nullable(); // in months like 6 months, 12 months, 24 ,months and so on

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
