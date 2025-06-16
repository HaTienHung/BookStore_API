<?php

namespace App\Repositories\Book;

use App\Models\Book;
use App\Repositories\BaseRepository;
use App\Repositories\Category\CategoryInterface;

use Illuminate\Database\Eloquent\ModelNotFoundException;


class BookRepository extends BaseRepository implements BookInterface
{
    public function __construct(
        protected Book $book,
        protected CategoryInterface $categoryRepository
    ) {
        parent::__construct($book);
        $this->categoryRepository = $categoryRepository;
    }
    // public function model()
    // {
    //     return Book::class;
    // }
    //     private function getCategoryWithChildrenIds($categoryId): array
    //     {
    //         $category = $this->categoryRepository->findByIdWithChildren($categoryId);
    // 
    //         if (!$category) {
    //             throw new ModelNotFoundException("Category not found");
    //         }
    // 
    //         $categoryIds = $category->children->pluck('id')->toArray();
    //         $categoryIds[] = $category->id;
    // 
    //         return $categoryIds;
    //     }
    private function getBooksInCategoryTree($categoryId)
    {
        return $this->model
            ->whereHas('category', function ($q) use ($categoryId) {
                $q->where('id', $categoryId)
                    ->orWhere('parent_id', $categoryId);
            })
            ->get();
    }
    public function getBooksByCategorySlug(string $slug)
    {
        // Lấy category với children trong một query
        $category = $this->categoryRepository->findBySlugWithChildren($slug);

        if (!$category) {
            throw new ModelNotFoundException("Category not found");
        }

        // Join trực tiếp thay vì whereIn
        return $this->getBooksInCategoryTree($category->id);
    }
}
