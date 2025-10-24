<?php

namespace App\DTO\Req;

use Spatie\LaravelData\Data;


class StoreSoilAnalysisRequestDto  extends Data
{
    public function __construct(
        public float $temperature,
        public float $humidity,
        public float $ph,
        public float $ec,
        public float $n,
        public float $p,
        public float $k,
        public ?string $sensor_model = null,
        public ?int $parcel_id = null
    ) {}
}
