<?php

namespace App\DTO\Requests\Aquilas;

use Spatie\LaravelData\Data;

class AquilasSendSmsRequestDto extends Data
{
    public function __construct(
        public string $from,
        public string $text,
        public array $to,
        public ?string $send_at = null,
    ) {}
}
