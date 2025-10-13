<?php

namespace App\Listeners;

use App\Events\OtpVerifed;
use App\Services\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class markPhoneNumnerAsVerifed
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private UserService $userService
    ) {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OtpVerifed $event): void
    {
        $this->userService->markPhoneNumberAsVerified($event->userId);
    }
}
