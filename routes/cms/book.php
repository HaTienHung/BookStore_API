<?php

use App\Enums\RoleType;
use App\Http\Controllers\CMS\BookControllerV2;
use Illuminate\Support\Facades\Route;

//Auth 
Route::prefix('cms')->group(function () {
  // Các route cần auth
  Route::controller(BookControllerV2::class)
    ->middleware(['auth:sanctum', 'role:admin|publisher'])
    ->group(function () {
      Route::get('/books/trash',  'getTrashed');       // <== đặt trước
      Route::post('/books/recovery',  'recovery');       // <== đặt trước
      Route::delete('books/soft-delete',  'softDelete');
      Route::get('/books',        'index');
      Route::post('/books/store', 'store');
      Route::put('/books/update/{id}',  'update');
      // Route::get('/collection/{id}',    'listBooksByCategoryId'); // Dont do that !!!!
      Route::get('/books/{id}',         'show');             // <== đặt sau cùng
    });
});
