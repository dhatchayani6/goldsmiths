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
        Schema::create('user_queries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jewel_id'); // Foreign key to the jewels table
            $table->unsignedBigInteger('user_id'); // Foreign key to the users table

            $table->string('image_url'); // URL of the image
            $table->text('query'); // The query or question from the user

            // Foreign key constraint (if you have a jewels table)
            $table->foreign('jewel_id')->references('id')->on('jewels')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_queries');
    }
};
