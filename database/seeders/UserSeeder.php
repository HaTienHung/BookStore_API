<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::factory()->count(20)->create();

        // Tạo 1 admin thủ công
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'phone_number' => '0387768880',
            'address' => 'Ha Noi',
            'password' => Hash::make('12345678'), // nhớ mật khẩu để đăng nhập
            'role_id' => Role::where('name', 'admin')->value('id'),
            'avatar_url' => 'https://img.freepik.com/premium-vector/man-avatar-profile-picture-isolated-background-avatar-profile-picture-man_1293239-4841.jpg?semt=ais_hybrid&w=740://via.placeholder.com/100',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
