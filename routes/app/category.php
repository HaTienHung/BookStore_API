<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\APP\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//Auth 
Route::prefix('app')->group(function () {
  Route::controller(CategoryController::class)
    ->group(function () {
      Route::get('/categories',  'index');
      Route::get('/categories/{slug}',  'show');
    });
});
