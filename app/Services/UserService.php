<?php

namespace App\Services;

use App\Enums\UserRoleEnum;
use App\Services\BaseService;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\CountryCallingCodeRepository;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    protected $repository;
    private $roleRepository;
    private $callingCodeRepository;

    public function __construct(
        UserRepository $repository,
        RoleRepository $roleRepository,
        CountryCallingCodeRepository $callingCodeRepository
    ) {
        parent::__construct($repository);
        $this->repository = $repository;
        $this->roleRepository = $roleRepository;
        $this->callingCodeRepository = $callingCodeRepository;
    }

    public function createFarmer(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        if (isset($data['calling_code'])) {
            $callingCode = $this->callingCodeRepository->findBy('calling_code', $data['calling_code']);
            if ($callingCode) {
                $data['country_calling_code_id'] = $callingCode->id;
            }
            unset($data['calling_code']);
        }

        $user = $this->repository->create($data);
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
}
