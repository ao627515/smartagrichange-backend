<?php

namespace App\Repositories;

use App\Models\RubricInfo;

class PlantRubricInfoRepository extends BaseRepository
{
    /**
     * Summary of model
     * @var RubricInfo
     */
    protected $model;

    public function __construct(RubricInfo $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}