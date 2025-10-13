<?php

namespace App\Repositories;

use App\Models\CountryCallingCode;
use App\Repositories\BaseRepository;

class CountryCallingCodeRepository extends BaseRepository
{
    protected $model;

    public function __construct(CountryCallingCode $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}
