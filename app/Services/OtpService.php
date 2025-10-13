<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Events\OtpVerifed;

class OtpService
{
    private AqilasService $aquilasService;
    private UserOtpService $userOtpService;
    private int $otpLength;
    private int $otpExpiry;
    private int $maxAttempts;
    private int $resendInterval;

    public function __construct(
        AqilasService $aquilasService,
        UserOtpService $userOtpService
    ) {
        $this->aquilasService = $aquilasService;
        $this->userOtpService = $userOtpService;
        $this->otpLength = config('otp.otp_length', 6);
        $this->otpExpiry = config('otp.otp_expiry', 5);
        $this->maxAttempts = config('otp.max_attempts', 3);
        $this->resendInterval = config('otp.resend_interval', 1);
    }

    public function generateOtp()
    {
        return $otp = str_pad(random_int(0, 999999), $this->otpLength, '0', STR_PAD_LEFT);
    }

    public function sendOtp($data)
    {
        return $this->aquilasService->sendSms($data);
    }

    public function verifyOtp($userId, string $otp): bool
    {
        $userOtp = $this->userOtpService->getLatestOtpForUser($userId);

        if (!$userOtp) {
            return false;
        }

        if ($userOtp->is_expired) {
            throw new Exception('OTP has expired');
        }

        if ($userOtp->attempts >= $this->maxAttempts) {
            throw new Exception('Maximum OTP verification attempts exceeded');
        }

        if ($userOtp->otp_code !== $otp) {
            $this->userOtpService->incrementAttempts($userOtp->id);
            throw new Exception('Invalid OTP');
        }

        if ($userOtp->is_used) {
            throw new Exception('OTP has already been used');
        }

        $this->userOtpService->markAsUsed($userOtp->id);
        event(new OtpVerifed($userId));
        return true;
    }
}