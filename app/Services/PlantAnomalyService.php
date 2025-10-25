<?php

namespace App\Services;

use App\Repositories\PlantAnomalyRepository;
use Illuminate\Support\Facades\Auth;

class PlantAnomalyService extends BaseService
{
    /**
     * Summary of repository
     * @var PlantAnomalyRepository
     */
    protected $repository;
    public function __construct(PlantAnomalyRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        $data['user_id'] = Auth::id();

        return $this->repository->create($data)->refresh();
    }
}
