<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable();
            $table->string('avatar_url')->nullable()->after('phone_number');
            $table->string('address')->nullable()->after('avatar_url');
            $table->unsignedBigInteger('role_id')->nullable()->after('address');
            //Its not necessary because in laravel 7+ just type foreignId
            $table->timestamp('inactive_at')->nullable()->after('updated_at');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('restrict');

            $table->index('phone_number');
            $table->index('address');
            $table->index('name');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone_number',
                'avatar_url',
                'address',
                'role_id',
                'inactive_at',
            ]);
        });
    }
};
