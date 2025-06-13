<?php

use App\Enums\RoleType;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

//Auth 
Route::prefix('cms')->group(function () {
  // Login không cần auth
  Route::get('/collection/{slug}', [BookController::class, 'listBooksByCategorySlug'])->name('listBooksByCategorySlug');
  Route::get('/books/{slug}', [BookController::class, 'show'])->name('show');


  // Các route cần auth
  Route::controller(BookController::class)
    ->middleware(['auth:sanctum', 'role:admin'])
    ->group(function () {
      Route::post('/books/store',  'store')->name('store');
      Route::put('/books/update/{id}',  'update')->name('update');
    });
});
