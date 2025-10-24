<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\PlantRubricInfoRepository;

class PlantRubricInfoService extends BaseService
{
    /**
     * Summary of repository
     * @var PlantRubricInfoRepository
     */
    protected $repository;

    public function __construct(PlantRubricInfoRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function create(array $data)
    {

        $data['user_id'] = Auth::id();
        $rubric = $this->repository->create($data);
        return $rubric;
    }
}
