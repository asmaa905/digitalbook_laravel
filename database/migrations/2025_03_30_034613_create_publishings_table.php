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
    Schema::create('publishing_houses', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('location');
        $table->string('website');
        $table->string('image')->nullable(); // Remove ->after('website')
        $table->timestamps();
        $table->softDeletes();
    });
}
 
     public function down()
     {
         Schema::dropIfExists('publishing_houses');
     }
};
