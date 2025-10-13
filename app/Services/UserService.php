<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\BaseService;

class UserService extends BaseService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }
}
