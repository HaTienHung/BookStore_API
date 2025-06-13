<?php

namespace App\Models;

use App\Traits\SlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory, SlugTrait;

    protected $fillable = [
        'title',
        'description',
        'author_id',
        'status',
        'thumbnail_url',
        'slug',
        'role_id',
        'price',
        'category_id',
        'publisher_id',
        'published_at',
    ];
}
