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
            'name' => 'Joe Vitale',
            'bio' => '',
            'birth_date' => '1953-12-29',
            'slug' => Str::slug('Joe Vitale'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
