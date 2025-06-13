<?php

namespace App\Repositories\Book;

use App\Repositories\BaseInterface;

interface BookInterface extends BaseInterface
{
  public function getBooksByCategorySlug(string $slug);
}
