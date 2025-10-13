<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\ParcelController;
use App\Http\Controllers\UserOtpController;
use App\Http\Controllers\RegisterController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('users')->group(function () {
    Route::post('/farmers/register', [RegisterController::class, 'registerFarmer']);
    Route::post('/{user}/verify-otp', [UserOtpController::class, 'verifyOtp']);
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
});

Route::apiResource('fields', FieldController::class);
Route::apiResource('parcels', ParcelController::class);
