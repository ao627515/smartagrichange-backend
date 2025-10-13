<?php

namespace App\Services;

use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Auth\AuthenticationException;

class AuthService
{
    public function __construct(
        private UserService $userService
    ) {}

    public function AuthFromUser($userId)
    {
        $user =  $this->userService->find($userId);
        if (!$user) {
            throw new Exception("User not found");
        }

        return JWTAuth::fromUser($user);
    }

    public function login(array $credentials)
    {
        if (!$token = JWTAuth::attempt($credentials)) {
            throw new AuthenticationException("Invalid credentials");
        }

        return $this->tokenResponse($token);
    }

    /**
     * Invalide le token courant (logout)
     */
    public function logout(): void
    {
        $token = JWTAuth::getToken();
        if ($token) {
            JWTAuth::invalidate($token);
        }
    }

    /**
     * Rafraîchie le token courant
     */
    public function refresh(): array
    {
        $token = JWTAuth::getToken();
        if (! $token) {
            throw new \RuntimeException('Token absent pour refresh');
        }

        $newToken = JWTAuth::refresh($token);
        return $this->tokenResponse($newToken);
    }

    /**
     * Retourne l'utilisateur authentifié
     */
    public function me()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    private function tokenResponse(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ];
    }
}