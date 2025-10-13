<?php

namespace App\Repositories;

use App\Models\UserOtp;

class UserOtpRepository extends BaseRepository
{
    protected $model;

    public function __construct(UserOtp $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}
