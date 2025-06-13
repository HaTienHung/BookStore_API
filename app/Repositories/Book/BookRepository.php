<?php

namespace App\Repositories\Book;

use App\Models\Book;
use App\Models\Category;
use App\Repositories\BaseRepository;
use App\Repositories\Category\CategoryInterface;
use Illuminate\Support\Facades\Log;

class BookRepository extends BaseRepository implements BookInterface
{
    protected $categoryRepository;
    public function __construct(Book $book, CategoryInterface $categoryRepository)
    {
        parent::__construct($book);
        $this->categoryRepository = $categoryRepository;
    }
    public function getBooksByCategorySlug(string $slug)
    {
        Log::debug($slug);
        // Eager load children luôn khi tìm category
        $category = $this->categoryRepository->findBySlugWithChildren($slug);
        // Log::debug($category);

        // Lấy ID của chính nó + các con
        $categoryIds = $category->children->pluck('id')->toArray();
        $categoryIds[] = $category->id;

        return $this->findAllById('category_id', $categoryIds);
    }
}
