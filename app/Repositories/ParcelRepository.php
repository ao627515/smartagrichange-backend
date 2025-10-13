<?php

namespace App\Repositories;

use App\Models\Parcel;

class ParcelRepository extends BaseRepository
{
    protected $model;

    public function __construct(Parcel $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}
