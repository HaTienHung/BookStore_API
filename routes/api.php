<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


foreach (glob(__DIR__ . '/app/*.php') as $route_file) {
  require $route_file;
}

foreach (glob(__DIR__ . '/cms/*.php') as $route_file) {
  require $route_file;
}

Route::post('/auth/login', [AuthController::class, 'login'])->name('login');
