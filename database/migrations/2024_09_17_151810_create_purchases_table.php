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
            $table->string('customer_name');
            $table->string('email');
            $table->string('mobile_number');
            $table->string('zip_code');
            $table->text('address');
            $table->string('payment_method'); // <-- Inspect this line
           $table->string('card_name')->nullable(); // Nullable for cash on delivery and PayPal
            $table->string('card_number')->nullable(); // Nullable for cash on delivery and PayPal
            $table->string('expiry_date')->nullable(); // Nullable for cash on delivery and PayPal
            $table->string('cvv')->nullable(); // Nullable for cash on delivery and PayPal
            $table->string('paypal_order_id')->nullable(); // Store PayPal order ID if using PayPal
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
