<?php

namespace App\DTO\Responses\Aquilas;

use Spatie\LaravelData\Data;

class AquilasSendSmsErrorResponseDto extends Data
{
    public function __construct(
        public bool $success,
        public string $message,
    ) {}
}
