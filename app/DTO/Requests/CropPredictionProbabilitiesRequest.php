<?php

namespace App\DTO\Requests;

use Spatie\LaravelData\Data;

class CropPredictionProbabilitiesRequest extends Data
{
    public function __construct(
        public int $k,
        public int $p,
        public int $temperature,
        public int $humidity,
        public int $top_n = 5,

    ) {}
}
