<?php

namespace App\DTO\Req\Aquilas;

use Spatie\LaravelData\Data;

class AquilasSendSmsRequestDto extends Data
{
    public function __construct(
        public array $to,
        public ?string $from = null,
        public ?string $text = null,
        public ?string $send_at = null,
    ) {
        if ($this->from === null) {
            $this->from = config('otp.sender_id');
        }
        if ($this->text === null) {
            $this->text = config('otp.message_template');
        }
    }

    public function getOtp($otp): string
    {
        return str_replace('{otp}', $otp, $this->text);
    }
}
