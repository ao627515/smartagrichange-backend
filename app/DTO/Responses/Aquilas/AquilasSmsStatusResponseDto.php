<?php

namespace App\DTO\Responses\Aquilas;

use Spatie\LaravelData\Data;

class AquilasSmsStatusResponseDto extends Data
{
    public function __construct(
        public string $id,
        public string $to,
        public ?string $updated_at = null,
        public ?string $sent_at = null,
        public string $status,
    ) {}
}
