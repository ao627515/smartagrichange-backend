<?php

namespace App\Services;

use App\Services\BaseService;

class CountryCallingCodeService extends BaseService
{
    protected $repository;

    public function __construct($repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }
}
