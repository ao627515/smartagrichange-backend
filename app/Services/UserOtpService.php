<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\UserOtpRepository;

class UserOtpService extends BaseService
{
    protected $repository;

    public function __construct(UserOtpRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        if (!isset($data['otp_expiry'])) {
            $data['expires_at'] = now()->addMinutes(config('otp.otp_expiry'));
        }

        if (!isset($data['max_attempts'])) {
            $data['max_attempts'] = config('otp.max_attempts', 3);
        }


        return $this->repository->create($data);
    }
}
