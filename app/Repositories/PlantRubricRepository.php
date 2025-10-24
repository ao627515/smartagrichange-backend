<?php

namespace App\Repositories;

use App\Models\Rubric;

class PlantRubricRepository extends BaseRepository
{
    /**
     * Summary of model
     * @var Rubric
     */
    protected $model;

    public function __construct(Rubric $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}
