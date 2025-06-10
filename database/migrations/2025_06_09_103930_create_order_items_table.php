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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id()->comment('Primary key');
            $table->foreignId('order_id')->constrained('orders')->onDelete('restrict'); // Đổi cascade thành restrict
            $table->foreignId('book_id')->constrained('books')->onDelete('restrict'); // Đổi cascade thành restrict
            $table->decimal('unit_price', 10, 2)->comment('Unit_price');
            $table->integer('quantity')->comment('Quantity');
            $table->timestamps();
            $table->index('book_id');
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
