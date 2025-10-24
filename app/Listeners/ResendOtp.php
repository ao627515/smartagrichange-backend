<?php

namespace App\Listeners;

use App\Services\OtpService;
use App\Services\UserService;
use App\Events\FarmerRegister;
use App\Services\UserOtpService;
use Exception;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\DTO\Req\Aquilas\AquilasSendSmsRequestDto;
use App\Events\OldFarmerRegistrationAttempt;

class ResendOtp
{
    public function __construct(
        private OtpService $otpService,
        private UserOtpService $userOtpService,
        private UserService $userService,
    ) {}


    /**
     * Handle the event.
     */
    public function handle(OldFarmerRegistrationAttempt $event): void
    {
        $this->otpService->resendOtp($event->userId);
    }
}
