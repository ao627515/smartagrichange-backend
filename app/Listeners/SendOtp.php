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

class SendOtp
{
    public function __construct(
        private OtpService $otpService,
        private UserOtpService $userOtpService,
        private UserService $userService,
    ) {}


    /**
     * Handle the event.
     */
    public function handle(FarmerRegister $event): void
    {
        // if (env('MODE_DEMO', false)) {
        //     return;
        // }
        // $user = $this->userService->find($event->userId);

        // if (!$user) {
        //     throw new Exception("User not found with ID");
        // }

        // $otp = $this->otpService->generateOtp();

        // create and send OTP
        // $otp = $this->otpService->generateOtp();

        // $req = AquilasSendSmsRequestDto::from([
        //     'to' => [$user->full_phone_number],
        // ]);
        // $req->text = $req->getOtp($otp);

        // $meta = $this->otpService->sendOtp($req);

        // $meta = $meta ? json_encode($meta->toArray()) : null;
        // // $meta = null;


        // $this->userOtpService->create([
        //     'user_id' => $user->id,
        //     'otp_code' => $otp,
        //     'meta' => $meta,
        // ]);

        $this->otpService->handleOtp($event->userId);
    }
}
