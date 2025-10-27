<?php

namespace App\Repositories;

use App\Models\AnomalyDetectionAnalysis;

class AnomalyAnalysisRepository extends BaseRepository
{
    /**
     * Summary of model
     * @var AnomalyDetectionAnalysis
     */
    protected $model;

    public function __construct(AnomalyDetectionAnalysis $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function createWithAnalysis(array $data)
    {
        $model = $this->model->create($data);
        $model->analysis()->create($data);
        return $model;
    }

    public function userAnalysesLatest($userId, $columns = ['*'])
    {
        return $this->model->whereHas('analysis', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->latest()->get($columns);
    }
}
