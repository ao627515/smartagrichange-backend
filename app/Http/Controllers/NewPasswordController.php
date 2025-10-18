<?php

namespace App\Http\Controllers;

use App\DTO\Data\ChangePasswordData;
use App\Http\Controllers\Controller;
use App\Http\Resources\SuccessResponseResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class NewPasswordController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {
        //
    }

    public function changeUserPassword(Request $request, string $user)
    {
        return $this->handleRequestException(function () use ($request, $user) {
            $dto = ChangePasswordData::validateAndCreate($request->all());
            $this->userService->changePassword($user, $dto->toArray());
            return new SuccessResponseResource('Password changed successfully', null);
        });
    }
}
