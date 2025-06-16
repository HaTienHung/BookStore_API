<?php

use App\Http\Controllers\APP\AuthController;
use Illuminate\Support\Facades\Route;


//Auth 
Route::prefix('auth')->group(function () {
  // Public Route
  Route::post('/login', [AuthController::class, 'login']);
  Route::post('/send-verify-code', [AuthController::class, 'sendVerifyCode']);

  // Auth Route
  Route::controller(AuthController::class)
    ->middleware(['auth:sanctum', 'role:user'])
    ->group(function () {
      Route::get('/me', 'me');
      Route::get('/logout', 'logout');
      Route::post('/change-password', 'changePassword');
    });
});
