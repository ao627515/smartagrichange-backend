<?php

namespace App\Services;

use App\Enums\UserRoleEnum;
use App\Services\BaseService;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;

class UserService extends BaseService
{
    protected $repository;
    private $roleRepository;

    public function __construct(UserRepository $repository, RoleRepository $roleRepository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
        $this->roleRepository = $roleRepository;
    }

    public function createFarmer(array $data)
    {
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
