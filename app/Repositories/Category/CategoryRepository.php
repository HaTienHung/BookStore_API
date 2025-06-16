<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryInterface
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }
    public function findBySlugWithChildren(string $slug)
    {
        return $this->model->with('children')->where('slug', $slug)->firstOrFail();
    }
    public function findByIdWithChildren(string $id)
    {
        return $this->model->with('children')->where('id', $id)->firstOrFail();
    }
}
