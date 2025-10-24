<?php

namespace App\Listeners;

use App\Services\UserService;
use InvalidArgumentException;
use App\Events\UserAttemptingRegsiter;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckPhoneNumberBeforeRegistration
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
    public function handle(UserAttemptingRegsiter $event): void
    {
        $data = $event->data;
        $phoneNumber = $data['phone_number'] ?? null;
        $callingCode = $data['calling_code'] ?? null;
        if ($phoneNumber && $callingCode) {
            if ($this->userService->phoneNumberExists($phoneNumber, $callingCode)) {
                $bool =  $this->userService->isPhoneNumberVerified($phoneNumber, $callingCode);
                if ($bool) {
                    throw new InvalidArgumentException('User with this phone number already exists.');
                }
            }
        } else {
            // Optionally, you can throw an exception or handle the missing data case
            throw new InvalidArgumentException('Phone number and calling code are required to verify phone number.');
        }
    }
}