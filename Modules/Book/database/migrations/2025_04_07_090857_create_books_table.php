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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->unique()->nullable();
            $table->string('author', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('isbn', 255)->nullable();
            $table->string('publisher', 255)->nullable();
            $table->string('year', 255)->nullable();
            $table->string('category', 255)->nullable();
            $table->string('language', 255)->nullable();
            $table->string('price', 255)->nullable();
            $table->string('stock', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
