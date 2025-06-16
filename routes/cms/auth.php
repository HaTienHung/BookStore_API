<?php

use App\Http\Controllers\CMS\AuthControllerV2;
use Illuminate\Support\Facades\Route;


//Auth 
Route::prefix('auth')->group(function () {
  // Public Route
  Route::post('cms/login', [AuthControllerV2::class, 'login']);
  Route::post('cms/send-verify-code', [AuthControllerV2::class, 'sendVerifyCode']);

  // Auth Route
  Route::controller(AuthControllerV2::class)
    ->middleware(['auth:sanctum', 'role:publisher|admin'])
    ->group(function () {
      Route::get('cms/me', 'me');
      Route::get('cms/logout', 'logout');
      Route::post('cms/change-password', 'changePassword');
    });
});
