<?php

namespace App\Listeners;

use App\Services\UserService;
use InvalidArgumentException;
use App\Events\UserAttemptingLogin;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ensurePhoneNumberIsVerified
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
    public function handle(UserAttemptingLogin $event): void
    {
        $data = $event->data;
        $phoneNumber = $data['phone_number'] ?? null;
        $callingCode = $data['calling_code'] ?? null;
        if ($phoneNumber && $callingCode) {
            $this->userService->ensurePhoneNumberIsVerified($phoneNumber, $callingCode);
        } else {
            // Optionally, you can throw an exception or handle the missing data case
            throw new InvalidArgumentException('Phone number and calling code are required to verify phone number.');
        }
    }
}
