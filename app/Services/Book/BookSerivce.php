<?php

namespace App\Services\Book;

use App\Enums\RoleType;
use App\Repositories\Book\BookInterface;
use App\Repositories\Category\CategoryInterface;

class BookSerivce
{

  public function __construct(
    protected BookInterface $bookRepository,
    protected CategoryInterface $categoryRepository
  ) {
    $this->bookRepository = $bookRepository;
    $this->categoryRepository = $categoryRepository;
  }

  // Check user role to return appropriate response for publisher or admin
  public function getBookList()
  {
    $user = current_user();
    if ($user->role->name === RoleType::PUBLISHER->value) {
      return $this->bookRepository->findAllById('publisher_id', [$user->publisher?->id]);
    }
    return $this->bookRepository->all();
  }

  public function getTrashedList()
  {
    $user = current_user();
    if ($user->role->name === RoleType::PUBLISHER->value) {
      return $this->bookRepository->getAllByWithTrash(['publisher_id' => $user->publisher?->id]);
    }
    return $this->bookRepository->getAllByWithTrash();
  }

  public function store(array $data)
  {
    $user = current_user();

    if ($user->role->name === RoleType::PUBLISHER->value) {
      $data['publisher_id'] = $user->publisher?->id;
    }
    // Log::debug('data', $data);
    return $this->bookRepository->createOrUpdate($data);
  }

  // Use filter is better !!!!!!!!
  // Check user role to return appropriate response for publisher or admin
  // Each publisher will receive a different response based on their publisher_id
  // public function getBooksByCategoryId($id)
  // {
  //   $user = current_user();
  //   if ($user->role->name === RoleType::PUBLISHER->value) {
  //     return $this->bookRepository->findAllBy([['category_id', 'IN', $this->bookRepository->getCategoryIds($id)], ['publisher_id', '=', $user->publisher?->id]]);
  //   }
  //   return $this->bookRepository->all();
  // }
}
