<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id()->comment('Primary key');

            $table->string('title', 100)->comment('Name of the book'); // Giới hạn độ dài title
            $table->text('description')->nullable()->comment('Content of the book');

            $table->foreignId('author_id')->constrained('authors')->onDelete('restrict'); // Đổi cascade thành restrict
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');

            $table->string('slug')->unique();

            $table->decimal('price', 10, 2)->nullable()->comment('Price of the book'); // Cho phép null thay vì default 0

            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->foreignId('publisher_id')->constrained('publishers')->onDelete('restrict');

            $table->timestamp('published_at')->nullable()->comment('Publication date'); // Đổi tên cột

            $table->timestamps();

            // Tách index để tối ưu hơn
            $table->index('author_id');
            $table->index('publisher_id');
            $table->index('category_id');
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
