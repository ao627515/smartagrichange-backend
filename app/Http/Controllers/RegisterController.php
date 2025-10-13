<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Services\UserRegisterService;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\ErrorResponseResource;
use App\Http\Resources\SuccessResponseResource;
use App\Http\Requests\Auth\RegisterFarmerRequest;
use App\Http\Resources\TokenResponse;

class RegisterController extends Controller
{


    public function __construct(
        private UserRegisterService $userRegisterService
    ) {}

    public function registerFarmer(RegisterFarmerRequest $request)
    {
        try {
            $validated = $request->validated();

            $tokenData = $this->userRegisterService->registerFarmer($validated);

            return new SuccessResponseResource('Farmer registered successfully', new TokenResponse($tokenData));
        } catch (Exception $e) {
            return new ErrorResponseResource("Farmer registered failed: ", $e->getMessage());
        }
    }
}
