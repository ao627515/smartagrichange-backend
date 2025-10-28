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
    ) {
        parent::__construct($model);
        $this->model = $model;
    }

    public function findOrFailByNameAndPlant(int $plantId, string $name, array $columns = ['*'])
    {
        return $this->model
            ->where('plant_id', $plantId)
            ->whereRaw("LOWER(name) = ?", [strtolower($name)])
            ->first($columns);
    }
}
