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
         Schema::create('publishers', function (Blueprint $table) {
            $table->id(); // Should be 'id' and not something like 'publisher_id'

             $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('identity');
            $table->string('job_title');
            $table->foreignId('publishing_house_id')->nullable()->constrained('publishing_houses')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps(); // <-- Add this line

         });
     }
     
    
 
     public function down()
     {
         Schema::dropIfExists('publishers');
     }
};
