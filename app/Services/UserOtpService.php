<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\UserOtpRepository;

class UserOtpService extends BaseService
{
    /**
     * Summary of repository
     * @var UserOtpRepository
     */
    protected $repository;

    public function __construct(UserOtpRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        if (!isset($data['otp_expiry'])) {
            $data['expires_at'] = now()->addMinutes((int)config('otp.otp_expiry'));
        }

        if (!isset($data['max_attempts'])) {
            $data['max_attempts'] = config('otp.max_attempts', 3);
        }


        return $this->repository->create($data);
    }

    public function getLatestOtpForUser(int $userId)
    {
        $userOtp = $this->repository->getLatestOtpForUser($userId);
        if (!$userOtp) {
            throw new \Exception('No OTP found for the user');
        }
        return $userOtp;
    }

    public function incrementAttempts($id)
    {
        $userOtp = $this->repository->findOrFail($id);
        $userOtp->attempts += 1;
        $userOtp->save();
    }

    public function markAsUsed($id)
    {
        $userOtp = $this->repository->findOrFail($id);
        $userOtp->is_used = true;
        $userOtp->save();
    }
}
