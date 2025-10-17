<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\DTO\Requests\FarmerProfileRequestDto;
use App\Http\Resources\SuccessResponseResource;

class FarmerProfileController extends Controller
{
    public function  __construct(
        private UserService $userService
    ) {}

    /**
     * Display the resource.
     */
    public function show($farmer)
    {
        return $this->handleRequestException(function () use ($farmer) {
            $user = $this->userService->findOrFail($farmer);

            return new SuccessResponseResource(
                'Farmer profile retrieved successfully',
                $user
            );
        });
    }

    /**
     * Update the resource in storage.
     */
    public function update($farmer, Request $request)
    {
        return $this->handleRequestException(function () use ($farmer, $request) {
            $dto = FarmerProfileRequestDto::validateAndCreate($request->all());
            $user = $this->userService->update($farmer, $dto->toArray());

            return new SuccessResponseResource(
                'Farmer profile updated successfully',
                new UserResource($user)
            );
        });
    }
}
