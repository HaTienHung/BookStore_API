<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // id integer primary key auto_increment
            $table->string('name', 50)->unique(); // varchar, bạn có thể thêm ->nullable() nếu muốn cho phép null
            $table->string('slug')->unique(); // varchar unique
            $table->unsignedBigInteger('parent_id')->nullable()->default(null); // parent_id integer, default null
            $table->timestamps(); // created_at và updated_at

            // Thêm index cho parent_id
            $table->index('parent_id');
            $table->index('slug');

            // Nếu bạn muốn tạo khóa ngoại tự tham chiếu (parent_id tham chiếu id của chính bảng này), có thể thêm:
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
}
