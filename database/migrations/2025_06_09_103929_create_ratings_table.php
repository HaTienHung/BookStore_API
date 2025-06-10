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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id()->comment('Primary key');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict'); // Đổi cascade thành restrict
            $table->foreignId('book_id')->constrained('books')->onDelete('restrict'); // Đổi cascade thành restrict
            $table->integer('rating')->comment('Rating number');
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('book_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
