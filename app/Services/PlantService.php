<?php

namespace App\Services;

use App\Repositories\PlantRepository;

class PlantService extends BaseService
{
    /**
     * Summary of repository
     * @var PlantRepository
     */
    protected $repository;

    public function __construct(PlantRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }
}
