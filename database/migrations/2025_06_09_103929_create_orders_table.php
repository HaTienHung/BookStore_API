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
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->comment('Primary key');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict'); // Đổi cascade thành restrict
            $table->decimal('total', 10, 2)->comment('Total');
            $table->enum('status', ['pending', 'cancelled', 'completed', 'shipping'])->default('pending')->comment('Order status');
            $table->timestamps();
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
