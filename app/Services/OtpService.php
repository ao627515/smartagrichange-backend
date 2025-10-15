<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Events\OtpVerifed;
use App\DTO\Requests\Aquilas\AquilasSendSmsRequestDto;

class OtpService
{
    private AqilasService $aquilasService;
    private UserOtpService $userOtpService;
    private UserService $userService;
    private int $otpLength;
    private int $otpExpiry;
    private int $maxAttempts;
    private int $resendInterval;

    public function __construct(
        AqilasService $aquilasService,
        UserOtpService $userOtpService,
        UserService $userService
    ) {
        $this->aquilasService = $aquilasService;
        $this->userOtpService = $userOtpService;
        $this->userService = $userService;
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
        if (env('MODE_DEMO', false)) {
            return;
        }
        return $this->aquilasService->sendSms($data);
    }

    public function resendOtp($userId)
    {
        $this->userService->findOrFail($userId);

        $lastOtp = $this->userOtpService->getLatestOtpForUser($userId);
        if ($lastOtp && !$lastOtp->is_expired) {
            $timeSinceLastOtp = now()->diffInSeconds($lastOtp->created_at);

            if ($timeSinceLastOtp < $this->resendInterval * 60) {
                $secondsLeft = $this->resendInterval * 60 - $timeSinceLastOtp;

                if ($secondsLeft < 60) {
                    $message = "Please wait {$secondsLeft} second" . ($secondsLeft > 1 ? 's' : '') . " before requesting a new OTP";
                } else {
                    $minutesLeft = ceil($secondsLeft / 60);
                    $message = "Please wait {$minutesLeft} minute" . ($minutesLeft > 1 ? 's' : '') . " before requesting a new OTP";
                }

                throw new Exception($message);
            }
        }

        $this->handleOtp($userId);
    }

    public function handleOtp($userId): void
    {
        $user = $this->userService->findOrFail($userId);

        $otp = $this->generateOtp();

        $req = AquilasSendSmsRequestDto::from([
            'to' => [$user->full_phone_number],
        ]);
        $req->text = $req->getOtp($otp);

        $meta = $this->sendOtp($req);

        $meta = $meta ? json_encode($meta->toArray()) : null;
        // $meta = null;


        $this->userOtpService->create([
            'user_id' => $user->id,
            'otp_code' => $otp,
            'meta' => $meta,
        ]);
    }

    public function verifyOtp($userId, string $otp): bool
    {
        $user = $this->userService->findOrFail($userId);

        if ($user->phone_number_verified_at) {
            throw new Exception('User phone number is already verified');
        }

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
