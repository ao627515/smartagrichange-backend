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

    public function getLatestOtpForUser(int $userId)
    {
        return $this->model->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
