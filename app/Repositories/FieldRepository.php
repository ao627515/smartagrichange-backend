<?php

namespace App\Repositories;

use App\Models\Field;

class FieldRepository extends BaseRepository
{
    protected $model;

    public function __construct(Field $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}