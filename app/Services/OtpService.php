<?php

namespace App\Services;

use App\Models\User;

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
}