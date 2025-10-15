<?php

namespace App\Services;

use Exception;
use App\Enums\UserRoleEnum;
use App\Services\OtpService;
use App\Services\BaseService;
use App\Events\FarmerRegister;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Repositories\CountryCallingCodeRepository;
use App\DTO\Requests\Aquilas\AquilasSendSmsRequestDto;

class UserService extends BaseService
{
    /**
     * Summary of repository
     * @var UserRepository
     */
    protected $repository;
    private $roleRepository;
    private $callingCodeRepository;

    public function __construct(
        UserRepository $repository,
        RoleRepository $roleRepository,
        CountryCallingCodeRepository $callingCodeRepository,
    ) {
        parent::__construct($repository);
        $this->repository = $repository;
        $this->roleRepository = $roleRepository;
        $this->callingCodeRepository = $callingCodeRepository;
    }

    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        if (isset($data['calling_code'])) {
            $callingCode = $this->callingCodeRepository->findBy('calling_code', $data['calling_code']);
            if ($callingCode) {
                $data['country_calling_code_id'] = $callingCode->id;
            }
        }

        $user = $this->repository->create($data);

        return $user;
    }

    public function createFarmer(array $data)
    {
        $user = $this->create($data);

        $this->attachRole($user->id, UserRoleEnum::FARMER);

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

    public function markPhoneNumberAsVerified($userId)
    {
        $user = $this->repository->findOrFail($userId);
        $user->phone_number_verified_at = now();
        $user->save();

        return $user;
    }

    public function ensurePhoneNumberIsVerified($phoneNumber, $callingCode)
    {
        $isVerified = $this->repository->isPhoneNumberVerified($phoneNumber, $callingCode);
        if (!$isVerified) {
            throw new Exception("Phone number {$callingCode}{$phoneNumber} is not verified. Please resend OTP to verify.");
        }

        return true;
    }
}
