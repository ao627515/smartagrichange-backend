<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResponseResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Resources\TokenResponse;
use App\Http\Requests\Auth\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\AuthenticationException;
use App\Http\Resources\SuccessResponseResource;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only(['phone_number', 'password']);
            $tokenData = $this->authService->login($credentials);
            return new SuccessResponseResource('Login successful', new TokenResponse($tokenData));
        } catch (AuthenticationException $e) {
            return new ErrorResponseResource('Authentication failed', $e->getMessage());
        } catch (JWTException $e) {
            return new ErrorResponseResource('JWT error', $e->getMessage());
        }
    }

    public function logout()
    {
        $this->authService->logout();
        return new SuccessResponseResource('Logout successful');
    }

    public function refresh()
    {
        try {
            $tokenData = $this->authService->refresh();
            return new SuccessResponseResource('Token refreshed successfully', new TokenResponse($tokenData));
        } catch (\Throwable $e) {
            return new ErrorResponseResource('Token refresh failed', $e->getMessage());
        }
    }

    public function me()
    {
        $user = $this->authService->me();
        return new SuccessResponseResource('User retrieved successfully', new UserResource($user));
    }
}
