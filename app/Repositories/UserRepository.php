<?php

namespace App\Repositories;

use App\Enums\UserRoleEnum;
use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    protected $model;
    private $roleRepository;
    public function __construct(User $model, RoleRepository $roleRepository)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->roleRepository = $roleRepository;
    }
}
