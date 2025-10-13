<?php

namespace App\DTO\Responses\Aquilas;

use Spatie\LaravelData\Data;

class AquilasSendSmsSuccessResponseDto extends Data
{
    public function __construct(
        public  bool $success,
        public string $message,
        public string $bulk_id,
        public int $cost,
        public string $currency

    ) {}
}