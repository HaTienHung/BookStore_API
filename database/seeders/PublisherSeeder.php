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
            'name' => 'NXB Giáo Dục Việt Nam',
            'email' => 'nxbgdvn@example.com',
            'address' => 'Hà Nội',
            'phone_number' => '0387769999',
            'slug' => Str::slug('NXB Giáo Dục Việt Nam'),
            'user_id' => 17,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
