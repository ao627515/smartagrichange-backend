<?php

namespace App\Repositories;

use App\Models\Anomaly;

class PlantAnomalyRepository extends BaseRepository
{
    /**
     * Summary of model
     * @var Anomaly
     */
    protected $model;

    public function __construct(
        Anomaly $model
    ){
        parent::__construct($model);
        $this->model = $model;
    }
}
