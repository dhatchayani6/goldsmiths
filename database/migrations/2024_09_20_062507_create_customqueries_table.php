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
        Schema::create('customqueries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jewel_id'); // Foreign key to the jewels table
            $table->unsignedBigInteger('user_id'); // Foreign key to the users table

            // Set up foreign key constraints
            $table->foreign('jewel_id')->references('id')->on('jewels')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('total_price', 10, 2); // Total price field with precision
            $table->string('customer_name'); // Customer name
            $table->string('mobile_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customqueries');
    }
};
