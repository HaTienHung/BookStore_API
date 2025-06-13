<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Author::create([
            'name' => 'Dale Carnegie',
            'bio' => '',
            'birth_date' => '1888-11-24',
            'slug' => Str::slug('Dale Carnegie'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
