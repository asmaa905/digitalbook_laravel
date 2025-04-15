<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            
            $table->date('start_date');
            $table->date('end_date')->nullable(); 
            $table->boolean('is_active')->default(true);//remove it 
            $table->integer('expired_at')->default(6)->nullable(); //it equal to  end_date - now
            $table->enum('status',['pending','confirm'])->default('pending');//may be 'pending','confirm' ,'cancel'

     
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};