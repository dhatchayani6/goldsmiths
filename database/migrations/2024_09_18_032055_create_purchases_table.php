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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jewel_id')->constrained('jewels')->onDelete('cascade'); // Assumes a 'jewels' table exists

            // Customer Information
            $table->string('customer_name');
            $table->string('email');
            $table->string('mobile_number');
            $table->string('zip_code');
            $table->text('address');
        
            // Payment Details
            $table->string('payment_method'); // Can be 'razorpay', 'card', 'paypal', 'cod' (cash on delivery)
        
            // Card Details (nullable for non-card payments)
            $table->string('card_name')->nullable(); 
            $table->string('card_number')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('cvv')->nullable(); 
        
            // Razorpay Details (nullable for non-Razorpay payments)
            $table->string('razorpay_payment_id')->nullable(); 
        
            // Amount
            $table->integer('amount');// Total purchase amount
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
