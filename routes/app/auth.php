<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//Auth 
Route::prefix('auth')->group(function () {
  // Login không cần auth
  Route::post('/login', [AuthController::class, 'login'])->name('login');
  Route::post('/send-verify-code', [AuthController::class, 'sendVerifyCode'])->name('send-verify-code');

  // Các route cần auth
  Route::controller(AuthController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
      Route::get('/me', 'me')->name('me');
      Route::get('/logout', 'logout')->name('logout');
      Route::post('/change-password', 'changePassword')->name('change-password');
    });
});
