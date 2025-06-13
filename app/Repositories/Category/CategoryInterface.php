<?php

namespace App\Repositories\Category;

use App\Repositories\BaseInterface;

interface CategoryInterface extends BaseInterface
{
  public function findBySlugWithChildren(string $slug);
}
