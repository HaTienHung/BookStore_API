<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//Auth 
Route::prefix('app')->group(function () {
  // Login không cần auth
  Route::get('/collection/{slug}', [BookController::class, 'listBooksByCategorySlug'])->name('listBooksByCategorySlug');
  Route::get('/books/{slug}', [BookController::class, 'show'])->name('show');
  Route::get('/books', [BookController::class, 'index'])->name('index');

  // Các route cần auth
  Route::controller(AuthController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
      Route::get('/me', 'me')->name('me');
      Route::get('/logout', 'logout')->name('logout');
      Route::post('/change-password', 'changePassword')->name('change-password');
    });
});
