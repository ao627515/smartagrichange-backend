<?php

namespace App\Http\Controllers;

use App\Http\Requests\OTP\VerifyOptRequest;
use App\Http\Resources\ErrorResponseResource;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\SuccessResponseResource;
use Exception;

class UserOtpController extends Controller
{
    public function __construct(
        private OtpService $otpService
    ) {
        //
    }
    public function verifyOtp($user, VerifyOptRequest $request)
    {

        try {
            $isValid = $this->otpService->verifyOtp($user, $request->otp_code);

            if ($isValid) {
                $message = 'OTP verified successfully';
                $data = null;
            } else {
                $message = 'OTP verification failed';
                $data = null;
            }

            return new SuccessResponseResource($message, $data);
        } catch (Exception $e) {
            return new ErrorResponseResource("OTP verification failed: ", $e->getMessage());
        }
    }

    public function resendOtp($user)
    {
        try {
            $this->otpService->resendOtp($user);
            return new SuccessResponseResource('OTP resent successfully', null);
        } catch (Exception $e) {
            return new ErrorResponseResource("Resend OTP failed: ", $e->getMessage());
        }
    }
}
