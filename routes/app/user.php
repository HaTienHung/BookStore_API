<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/users', [UserController::class, 'index'])->name('index');

Route::controller(UserController::class)->group(function () {
  Route::get('/users', 'index');
});
