<?php

namespace App\Repositories;

use App\Models\SoilAnalysis;

class SoilAnalysisRepository extends BaseRepository
{
    /**
     * Summary of model
     * @var SoilAnalysis
     */
    protected $model;
    public function __construct(SoilAnalysis $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function createWithAnalysis(array $data)
    {
        $model = $this->model->create($data);
        $model->analysis()->create($data);
        return $model->refresh()->load('analysis');
    }
}
