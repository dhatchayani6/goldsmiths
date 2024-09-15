<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jewel_queries', function (Blueprint $table) {
            $table->id();
            // Foreign key for the jewel the query is about
            $table->foreignId('jewel_id')->constrained('jewels')->onDelete('cascade');

            // Foreign key for the user who submitted the query
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // The fields for storing the query details
            $table->string('name');
            $table->string('email');
            $table->text('message');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jewel_queries');
    }
};
