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
        Schema::create('book_images', function (Blueprint $table) {
            $table->id()->comment('Primary key');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade')->comment('Foreign key to books table');
            $table->text('image_url')->comment('URL of the image');
            $table->enum('type', ['thumbnail', 'front', 'back'])->default('thumbnail')->comment('Type of the image');
            $table->integer('order')->default(0)->comment('Display order of the image');
            $table->timestamps();

            // Indexes
            $table->index('book_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_images');
    }
};
