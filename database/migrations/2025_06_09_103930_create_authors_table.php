<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id(); // id integer primary key tự tăng
            $table->string('name',  50); // not null
            $table->text('bio')->nullable(); // có thể null nếu muốn
            $table->date('birth_date')->nullable(); // có thể null
            $table->string('slug')->nullable()->unique();
            $table->timestamps(); // created_at và updated_at
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
}
