<?php

namespace App\DTO\Responses\Aquilas;

use Spatie\LaravelData\Data;

class AquilasCreditResponseDto extends Data
{
    public function __construct(
        public $success,
        public $credits,
        public $currency
    ) {}
}
