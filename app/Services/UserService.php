<?php

namespace App\Services;

use App\DTO\Requests\Aquilas\AquilasSendSmsRequestDto;
use App\Enums\UserRoleEnum;
use App\Services\OtpService;
use App\Services\BaseService;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Repositories\CountryCallingCodeRepository;

class UserService extends BaseService
{
    protected $repository;
    private $roleRepository;
    private $callingCodeRepository;
    private $otpService;
    private $userOtpService;

    public function __construct(
        UserRepository $repository,
        RoleRepository $roleRepository,
        CountryCallingCodeRepository $callingCodeRepository,
        OtpService $otpService,
        UserOtpService $userOtpService
    ) {
        parent::__construct($repository);
        $this->repository = $repository;
        $this->roleRepository = $roleRepository;
        $this->callingCodeRepository = $callingCodeRepository;
        $this->otpService = $otpService;
        $this->userOtpService = $userOtpService;
    }

    public function createFarmer(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        if (isset($data['calling_code'])) {
            $callingCode = $this->callingCodeRepository->findBy('calling_code', $data['calling_code']);
            if ($callingCode) {
                $data['country_calling_code_id'] = $callingCode->id;
            }
        }

        $user = $this->repository->create($data);
        $this->attachRole($user->id, UserRoleEnum::FARMER);


        // create and send OTP
        $otp = $this->otpService->generateOtp();

        $meta = $this->otpService->sendOtp(AquilasSendSmsRequestDto::from([
            'to' => [$data['calling_code'] . $data['phone_number']],
        ]));


        $this->userOtpService->create([
            'user_id' => $user->id,
            'otp' => $otp,
            'meta' => json_encode($meta->toArray()),
        ]);
        return $user;
    }

    public function attachRole($userId, UserRoleEnum $roleName)
    {
        $user = $this->repository->find($userId);
        if (!$user) {
            return null;
        }

        $role = $this->roleRepository->findBy('name', $roleName->value);
        if ($role) {
            $user->roles()->attach($role->id);
        }

        return $user;
    }
}