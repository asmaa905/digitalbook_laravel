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
         Schema::create('payments', function (Blueprint $table) {
             $table->id();
             $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
             $table->foreignId('subscription_id')->constrained('subscriptions')->onDelete('cascade');
             $table->decimal('amount', 8, 2);
             $table->enum('payment_method', ['Credit Card', 'PayPal', 'Bank Transfer']);
             $table->date('payment_date');
             $table->enum('status', ['Paid', 'Failed']);
             $table->timestamps();
         });
     }
 
     public function down()
     {
         Schema::dropIfExists('payments');
     }
};
