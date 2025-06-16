<?php

namespace App\Models;

use App\Traits\SlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory, SlugTrait, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'author_id',
        'status',
        'thumbnail_url',
        'slug',
        'price',
        'category_id',
        'publisher_id',
        'published_at',
    ];
    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function scopeInCategories($query, array $categoryIds)
    {
        return $query->whereIn('category_id', $categoryIds);
    }
}
