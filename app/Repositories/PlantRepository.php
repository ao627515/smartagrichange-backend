<?php

namespace App\Repositories;

use App\Models\Plant;

class PlantRepository extends BaseRepository
{
    /**
     * Summary of model
     * @var Plant
     */
    protected $model;

    public function __construct(Plant $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}
