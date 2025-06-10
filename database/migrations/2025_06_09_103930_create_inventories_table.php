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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id()->comment('Primary key');
            $table->foreignId('book_id')->constrained('books')->onDelete('restrict'); // Đổi cascade thành restrict
            $table->enum('type', ['export', 'import'])->comment('Type');
            $table->integer('quantity');
            $table->timestamps();
            $table->index('book_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
