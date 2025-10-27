<?php

namespace App\Services;

use App\Models\Analysis;
use App\Repositories\AnalysisRepository;
use Exception;

class AnalysisService extends BaseService
{
    /**
     * Summary of repository
     * @var AnalysisRepository
     */
    protected  $repository;
    /**
     * Summary of __construct
     * @param AnalysisRepository $repository
     */
    public function __construct(
        AnalysisRepository $repository,
        private UserService $userService
    ) {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function getByUserWithRelations(int $userId, array $relations = [], $columns = ['*'])
    {
        $this->userService->findOrFail($userId);
        return $this->repository->getByUserLatestWithRelations($userId, $relations, $columns);
    }

    public function allLatestWithRelations(array $relations = [], $columns = ['*'])
    {
        return $this->repository->allLatestWithRelations($relations, $columns);
    }
}
