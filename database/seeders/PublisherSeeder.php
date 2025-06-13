<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Publisher::create([
            'name' => 'NXB Kim Đồng',
            'email' => 'nxbkimdong@example.com',
            'address' => 'Hà Nội',
            'phone_number' => '0387768888',
            'slug' => Str::slug('NXB Kim Đồng'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
