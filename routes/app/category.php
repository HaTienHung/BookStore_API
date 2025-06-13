<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//Auth 
Route::prefix('app')->group(function () {
  // Login không cần auth
  Route::get('/categories', [CategoryController::class, 'index'])->name('index');
  Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('show');

  // Các route cần auth
  Route::controller(AuthController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
      Route::get('/me', 'me')->name('me');
      Route::get('/logout', 'logout')->name('logout');
      Route::post('/change-password', 'changePassword')->name('change-password');
    });
});
