<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ParcelController;
use App\Http\Controllers\UserOtpController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\AnomalyController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Resources\SuccessResponseResource;
use App\Http\Controllers\SoilAnalysisController;
use App\Http\Controllers\FarmerProfileController;
use App\Http\Controllers\PlantController;
use App\Models\Role;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('users')->group(function () {
    Route::post('/farmers/register', [RegisterController::class, 'registerFarmer']);
    Route::post('/{user}/verify-otp', [UserOtpController::class, 'verifyOtp']);
    Route::post('/{user}/resend-otp', [UserOtpController::class, 'resendOtp']);

    Route::middleware('auth:api')->group(function () {

        Route::apiSingleton('farmers.profile', FarmerProfileController::class);
    });
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('login', function () {
        return new SuccessResponseResource('You are not logged in', null);
    })->name('login');

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('fields', FieldController::class);
    Route::get('fields/{field}/parcels', [FieldController::class, 'getParcels']);
    Route::apiResource('parcels', ParcelController::class);
    Route::apiResource('soil-analyses', SoilAnalysisController::class)->except('update');
    Route::get('users/{user}/soil-analyses', [SoilAnalysisController::class, 'userAnalyses']);
    Route::post('users/{user}/change-password', [NewPasswordController::class, 'changeUserPassword']);
    Route::apiResource('analyses', AnalysisController::class)->except('update');
    Route::apiResource('media', MediaController::class);
    Route::apiResource('plants', PlantController::class);
    Route::get('plants-with-rubrics/{plant}', [PlantController::class, 'showWithRubrics']);
    Route::get('plants-with-rubrics', [PlantController::class, 'indexWithRubrics']);
    Route::apiResource('plants-anomalies', AnomalyController::class);
});