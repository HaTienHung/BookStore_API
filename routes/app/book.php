<?php

use App\Http\Controllers\APP\BookController;
use Illuminate\Support\Facades\Route;


//Auth 
Route::prefix('app')->group(function () {
  Route::controller(BookController::class)
    ->group(function () {
      Route::get('/collection/{slug}', 'listBooksByCategorySlug');
      Route::get('/books/{slug}',  'show');
      Route::get('/books',  'index');
    });
});
