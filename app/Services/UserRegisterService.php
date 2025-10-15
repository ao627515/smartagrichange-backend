<?php

namespace App\Services;

use App\Enums\UserRoleEnum;
use App\Events\FarmerRegister;

class UserRegisterService
{
    public function __construct(
        private UserService $userService
    ) {}

    public function registerFarmer(array $data)
    {
        $user = $this->userService->createFarmer($data);

        $this->userService->attachRole($user->id, UserRoleEnum::FARMER);

        event(new FarmerRegister($user->id));

        // $tokenData = $this->authService->AuthFromUser($user->id);

        return $user->refresh();
    }
}
