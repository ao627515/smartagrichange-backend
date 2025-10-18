<?php

namespace App\Repositories;

use App\Models\Analysis;

class AnalysisRepository extends BaseRepository
{
    /**
     * Summary of model
     * @var Analysis
     */
    protected $model;

    public function __construct(Analysis $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function getByUserLatest(int $userId, $columns = ['*'])
    {
        return $this->model->where('user_id', $userId)->latest()->get($columns);
    }

    public function allLatestWithRelations(array $relations = [], $columns = ['*'])
    {
        return $this->model->with($relations)->latest()->get($columns);
    }

    public function getByUserLatestWithRelations(int $userId, array $relations = [], $columns = ['*'])
    {
        return $this->model
            ->where('user_id', $userId)
            ->with($relations)
            ->latest()
            ->get($columns);
    }
}
