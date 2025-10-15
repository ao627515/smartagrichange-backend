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
        $user = null;

        if ($this->userService->phoneNumberExistsAndNotVerified($data['phone_number'], $data['calling_code'])) {
            $user = $this->userService->findUserByPhoneNumberAndCallingCode(
                $data['phone_number'],
                $data['calling_code'],
                ['id']
            );
            $this->userService->update($user->id, $data);
            $user = $this->userService->find($user->id);
        } else {
            $user = $this->userService->createFarmer($data);
            $this->userService->attachRole($user->id, UserRoleEnum::FARMER);
        }

        // Event déclenché dans tous les cas
        event(new FarmerRegister($user->id));

        return $user->refresh();
    }
}
