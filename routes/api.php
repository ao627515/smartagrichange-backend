<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\ParcelController;
use App\Http\Controllers\UserOtpController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('users')->group(function () {
    Route::post('/farmers/register', [UserController::class, 'storeFarmer']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);
    // Route::post('/send-otp', [UserOtpController::class, 'sendOtp']);
    Route::post('/{user}/verify-otp', [UserOtpController::class, 'verifyOtp']);
});

Route::apiResource('fields', FieldController::class);
Route::apiResource('parcels', ParcelController::class);