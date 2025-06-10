<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publisher_author', function (Blueprint $table) {
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('publisher_id');

            // Composite Primary Key
            $table->primary(['author_id', 'publisher_id']);

            // Foreign Keys
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
            $table->foreign('publisher_id')->references('id')->on('publishers')->onDelete('cascade');

            $table->timestamps();

            // Optional Indexes (nếu cần truy vấn riêng từng field)
            $table->index('author_id');
            $table->index('publisher_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publisher_author');
    }
};
