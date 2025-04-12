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
        Schema::table('readed_books', function (Blueprint $table) {
            $table->timestamps(); // adds created_at and updated_at
            $table->softDeletes(); // adds deleted_at
        });
    }
    
    public function down()
    {
        Schema::table('readed_books', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropSoftDeletes();
        });
    }
    
};
